<?php

namespace App\Http\Controllers;

use App\Interface\SheetInterface;
use App\Models\Adverb;

class AdverbController extends SheetController implements SheetInterface
{
    protected $model = Adverb::class;
    protected $route = 'adverb';

    public function sheetConfiguartions($data)
    {
        $configuations = [
            'data' => $data,
            'columns' => [null, null, null, ['width' => '100px'], null, null],
            'order' => [
                [0, 'desc']
            ],
            'scrollX' => true,
        ];

        return $configuations;
    }
}
