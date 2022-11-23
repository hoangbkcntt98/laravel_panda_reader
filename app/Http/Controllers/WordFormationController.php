<?php

namespace App\Http\Controllers;

use App\Interface\SheetInterface;
use App\Models\WordFormation;
use Illuminate\Http\Request;

class WordFormationController extends SheetController implements SheetInterface
{
    protected $model = WordFormation::class;
    protected $route = 'word_formation';
    
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
}
