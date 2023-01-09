<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Trait\GoogleExtension;
use Illuminate\Http\Request;
use Google\Service\Sheets;
use Illuminate\Support\Arr;
use App\Enums\Notification\Status;
use App\Enums\Notification\Type;
use App\Enums\Notification\ReadPermission;
use App\Models\DataFormation;
use App\Models\DataFormationColumn;
use App\Trait\ModelUtil;
use Illuminate\Support\Facades\File;
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
                'is_skipped' => 0
            ]
        )->first();
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
            foreach($dataColumns as $column)
            {
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
            'columns' => [null, null, null, ['width' => '100px'], null, null, null,  ['width' => '100px']],
            'order' => [
                [0, 'desc']
            ]
        ];

        return $configuations;
    }


    public function makeHTML(Request $request)
    {
        $type = $request->get('mat_type');
        $model = $this->getMaterialModel($type);
        $query = $model::query();


        $material = $request->get('route');
        $style = sprintf('template/%s/style.css', $material);
        $template = sprintf('template/%s/template.html', $material);
        $template = File::get($template);
        $body = '';

        $from = $request->get('from');
        $to = $request->get('to');
        if ($from) {
            $query->where('no', ">=", intval($from));
        }
        if ($to) {
            $query->where('no', "<=", intval($to));
        }
        if ($from && $to) {
            if ($from > $to) {
                return 'Invalid Value: From > To';
            }
        }
        $query->orderBy('no');
        $items = $query->get();
        $display_columns = $model::getTableColumns();
        foreach ($items as $item) {
            $content = $template;
            if ($item->no == 0) continue;
            foreach ($display_columns as $column) {
                $replace_text = $item->{$column};
                if ($column != 'kanji') $replace_text = '<span>' . nl2br($replace_text) . '</span>';
                $need_replace = "{{{$column}}}";

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
}
