<?php

namespace App\Trait;

use App\Models\DataFormation;

trait ModelUtil
{

    public function getMaterialModel(string $type)
    {
        $model = app('material.' . $type);
        return $model::class;
    }

    public function getMaterialData($materialId)
    {
        $data = DataFormation::where('material_id', $materialId)->get();
        $data = collect($data)->groupBy('row');
        $fomattedData = [];
        foreach ($data as $row) {
            foreach ($row as $rowData) {
                $fomattedData[$rowData->row][$rowData->column] = $rowData->value;
            }
        }
        return $fomattedData;
    }
}
