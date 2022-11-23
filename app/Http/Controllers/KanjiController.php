<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanji;

class KanjiController extends SheetController
{
    protected $model = Kanji::class;
    protected $route = 'kanji';

    public function sheetConfiguartions($data)
    {
        $configuations = [
            'data' => $data,
            'columns' => [
                ['width' => '50px'],
                null,
                ['width' => '50px'],
                null,
                ['width' => '100px'],
                ['width' => '100px'],
                null,
                ['width' => '300px'],
                ['width' => '300px'],
                ['width' => '250px'],
                ['width' => '250px'],
            ],
            'order' => [
                [0, 'desc']
            ],
        ];

        return $configuations;
    }
}
