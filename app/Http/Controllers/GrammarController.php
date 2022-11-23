<?php

namespace App\Http\Controllers;

use App\Interface\SheetInterface;
use App\Models\Grammar;
use Illuminate\Http\Request;

class GrammarController extends SheetController implements SheetInterface
{
    protected $model = Grammar::class;
    protected $route = 'grammar';

    public function sheetConfiguartions($data)
    {
        $configuations = [
            'data' => $data,
            'columns' => [
                ['width' => '50px'],
                ['width' => '150px'],
                null,
                null,
                ['width' => '220px'],
                null,
                null,
                ['width' => '150px'],
            ],
            'order' => [
                [0, 'desc']
            ],
        ];

        return $configuations;
    }
}
