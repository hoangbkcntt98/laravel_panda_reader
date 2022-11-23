<?php

namespace App\Http\Controllers;

use App\Interface\SheetInterface;
use App\Models\Vocabulary;

class VocabularyController extends SheetController implements SheetInterface
{
    protected $model = Vocabulary::class;
    protected $route = 'vocabulary';

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
}
