<?php

namespace App\Http\Controllers;

use App\Enums\Notification\ReadPermission;
use App\Enums\Notification\Status;
use App\Enums\Notification\Type;
use App\Models\SheetInfo;
use Illuminate\Http\Request;
use Google\Service\Sheets;
use App\Trait\GoogleExtension;
use Illuminate\Support\Arr;

class SheetController extends Controller
{
    use GoogleExtension;

    protected $model;
    protected $route;

    public function index(Request $request)
    {
        $collection = $this->model::get($this->model::DISPLAY_COLUMNS);
        $data = array_map(function ($item) {
            return array_values($item);
        }, $collection->toArray());
        $heads = $this->model::DISPLAY_COLUMNS;
        $heads = array_map(function ($item) {
            $trans = trans(sprintf("pages/%s.%s", $this->route, $item));
            return $trans;
        }, $heads);
        $fomatted_data = $this->formatData($data);
        $config = $this->sheetConfiguartions($fomatted_data);
        return view("pages.sheet", [
            'config' => $config,
            'heads' => $heads,
            'route' => $this->route,
            'use_config' => $this->use_config ?? true,
            'raw_data' => $data,
            'collection' => $collection
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
    public function sync(Request $request)
    {
        $client = $this->getUserClient();
        $service = new Sheets($client);
        $sheet_info = SheetInfo::where('route', $this->route)->first();
        $sheet_name =  $sheet_info->sheet_name;
        $sheet_range = $sheet_info->sheet_range;
        $sheet_id = $sheet_info->sheet_id;
        $range = sprintf("%s!%s", $sheet_name, $sheet_range);
        $sheet_data = $service->spreadsheets_values->get($sheet_id, $range);
        $sheet_data = $sheet_data['values'];
        $column_map = $this->model::COLUMN_MAP;
        $display_columns = $this->model::DISPLAY_COLUMNS;
        $this->model::whereNotNull('id')->delete();
        foreach ($sheet_data as $row) {
            $data = [];
            foreach ($display_columns as $column) {
                $column_data = Arr::get($row, $column_map[$column], '');
                $data[$column] = $column_data;
            }
            if (!$data['sentence'] && !$data['word']) continue;
            $this->model::create($data);
        }
        $user = auth()->user();
        $notiService = app('service.notification');
        $notiService->create([
            'content' =>  trans('notification.sync_success', [
                'username' => $user->name,
                'data_type' => trans('sheet_type.' . $this->route)
            ]),
            'user_id' => $user->id,
            'status' => Status::UNREAD,
            'type' => Type::SYNC,
            'read_permission' => ReadPermission::USER
        ]);
        return redirect(route($this->route));
    }
}
