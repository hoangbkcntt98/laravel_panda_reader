<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Trait\GoogleExtension;
use Illuminate\Http\Request;
use Google\Service\Sheets;
use App\Enums\Notification\Status;
use App\Enums\Notification\Type;
use App\Enums\Notification\ReadPermission;
use App\Models\DataFormation;
use App\Models\DataFormationColumn;
use App\Models\Document;
use App\Trait\ModelUtil;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    use GoogleExtension, ModelUtil;

    public function get(Request $request, $id)
    {
        $sheetInformation = Material::where('id', $id)->first();
        $dataFormationColumn = DataFormationColumn::where(
            [
                'material_id' => $id,
                'is_skipped' => 0,
                'is_custom' => 0
            ]
        )->get();
        $data = $this->getMaterialData($id);
        $heads = $dataFormationColumn->pluck('column_name')->toArray();
        $fomatted_data = $this->formatData($data);
        $config = $this->sheetConfiguartions($fomatted_data);
        $sheetUrl = 'https://docs.google.com/spreadsheets/d/' . $sheetInformation->sheet_id;
        return view("pages.material", [
            'config' => $config,
            'heads' => $heads,
            'route' => url()->current(),
            'use_config' => true,
            'raw_data' => $data,
            'sheet_url' => $sheetUrl,
            'sheet_information' => $sheetInformation,
            'id' => $id
        ]);
    }

    public function formatData($data)
    {
        $data = array_map(function ($row) {
            $fomatted_row = array_map(function ($cell) {
                return '<span>' . nl2br($cell) . '</span>';
            }, $row);
            return $fomatted_row;
        }, $data);
        return $data;
    }

    /**
     * 
     * Sync data from google sheet
     * 
     * @param Request $request
     * @param mixed $id
     * 
     * @return 
     */
    public function sync(Request $request, $id)
    {
        $client = $this->getUserClient();
        $service = new Sheets($client);
        $sheetInformation = Material::where('id', $id)->first();
        $sheetName =  $sheetInformation->sheet_name;
        $sheetRange = $sheetInformation->sheet_range;
        $sheetId = $sheetInformation->sheet_id;
        $range = sprintf("%s!%s", $sheetName, $sheetRange);
        $sheet_data = $service->spreadsheets_values->get($sheetId, $range);
        $sheet_data = $sheet_data['values'];

        $dataColumns = DataFormationColumn::where([
            'material_id' => $id,
            'is_skipped' => false
        ])->first();
        $dataColumns = $dataColumns->pluck('column');

        DataFormation::where('material_id', $id)->whereNotNull('id')->delete();

        foreach ($sheet_data as $i => $row) {
            foreach ($dataColumns as $column) {
                $value = $row[$column] ?? '';
                DataFormation::create([
                    'row' => $i,
                    'column' => $column,
                    'value' => $value,
                    'material_id' => $id
                ]);
            }
        }
        $user = auth()->user();
        $notiService = app('service.notification');
        $redirectTo = "/materials/{$id}";
        $notiService->create([
            'content' =>  trans('notification.sync_success', [
                'username' => $user->name,
                'data_type' => $sheetInformation->mat_type
            ]),
            'user_id' => $user->id,
            'status' => Status::UNREAD,
            'type' => Type::SYNC,
            'read_permission' => ReadPermission::USER
        ]);
        $redirectTo = "/materials/{$id}";

        return redirect($redirectTo);
    }

    public function sheetConfiguartions($data)
    {
        $configuations = [
            'data' => $data,
            'columns' => [null, null, null, ['width' => '100px'], null, null],
            'order' => [
                [0, 'desc']
            ]
        ];

        return $configuations;
    }


    public function makeHTML(Request $request, $id)
    {
        $materialId = $id;
        $material = Material::where('id', $id)->first();

        $style = $material->css;
        $template = $material->html;
        $from = $request->get('from') ?? 0;
        $to = $request->get('to') ?? 100000;
        $data = $this->getMaterialData($materialId);

        $orderColumn = $this->getColumnByKey('No', $materialId);

        $data = collect($data);
        $body = '';

        $data = $data->filter(function ($item) use ($orderColumn, $from, $to) {
            $val = $item[$orderColumn];
            return $val >= intval($from) && $val <= $to;
        });

        if ($from && $to) {
            if ($from > $to) {
                return 'Invalid Value: From > To';
            }
        }

        $dataFormationColumn = DataFormationColumn::where(
            [
                'material_id' => $id,
                'is_skipped' => 0
            ]
        )->get();
        // dd($dataFormationColumn);

        foreach ($data as $item) {
            $content = $template;
            // if ($item[intval($this->getColumnByKey('No'))] == 0) continue;
            foreach ($dataFormationColumn as $column) {
                // dd($column->column);
                $replace_text = $item[$column->column];
                if ($column->name != 'Kanji') $replace_text = '<span>' . nl2br($replace_text) . '</span>';
                $need_replace = "{{{$column->column_name}}}";

                if (Str::contains($content, $need_replace)) {
                    $content = Str::replace($need_replace, $replace_text, $content);
                }
            }
            $body .= $content;
        }
        return view('pages.review_html', [
            'body' => $body,
            'style' => $style
        ]);
    }

    public function create(Request $request)
    {
        $documents = Document::all();
        return view('pages.material.create', [
            'documents' => $documents
        ]);
    }

    public function store(Request $request)
    {
        $sheetId = $request->get('sheet_id');
        $sheetName = $request->get('sheet_name');
        $sheetRange = $request->get('sheet_range');
        $documentId = $request->get('document_id');

        $html = $request->get('html') ?? '';
        $css = $request->get('css') ?? '';


        $columnName = $request->get('column_name');
        $skipped = $request->get('skipped');
        $columnNo = $request->get('column');
        $custom = $request->get('custom');

        $material = Material::create([
            'document_id' => $documentId,
            'sheet_id' => $sheetId,
            'sheet_name' => $sheetName,
            'sheet_range' => $sheetRange,
            'html' => $html,
            'css' => $css
        ]);

        for ($i = 0; $i < count($columnNo); $i++) {
            $rowData = [
                'material_id' => $material->id,
                'column' => $columnNo[$i],
                'column_name' => $columnName[$i],
                'is_skipped' => $skipped[$i],
                'is_custom' => $custom[$i]
            ];
            DataFormationColumn::create($rowData);
        }


        return redirect(route('documents.index'));
    }
}
