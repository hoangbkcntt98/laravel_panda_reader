<?php

namespace App\Trait;

use App\Models\DataFormation;
use App\Models\DataFormationColumn;

trait ModelUtil
{

    public function getMaterialModel(string $type)
    {
        $model = app('material.' . $type);
        return $model::class;
    }

    public function getMaterialData($materialId)
    {
        $customColumns = DataFormationColumn::where('material_id', $materialId)->where('is_custom', 1)->get();
        $customColumns = $customColumns->toArray();
        $data = DataFormation::where('material_id', $materialId)->get();
        $data = collect($data)->groupBy('row');
        $fomattedData = [];
        foreach ($data as $row) {
            foreach ($row as $rowData) {
                if(!in_array($rowData->column, $customColumns))
                $fomattedData[$rowData->row][$rowData->column] = $rowData->value;
            }
        }
        return $fomattedData;
    }

    public function getMaterialDataByConditions(array $conditions)
    {
        $data = DataFormation::where($conditions)->get();
        $data = collect($data)->groupBy('row');
        $fomattedData = [];
        foreach ($data as $row) {
            foreach ($row as $rowData) {
                $fomattedData[$rowData->row][$rowData->column] = $rowData->value;
            }
        }
        return $fomattedData;
    }

    public function getColumnByKey($key, $materialId)
    {
        $column = DataFormationColumn::where('material_id', $materialId)
            ->where('column_name', $key)
            ->first();
        return $column->column;
    }
}
