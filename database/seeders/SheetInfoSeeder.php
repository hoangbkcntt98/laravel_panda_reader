<?php

namespace Database\Seeders;

use App\Models\SheetInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SheetInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SheetInfo::truncate();
        $data = [
            [
                'sheet_id' => '1HCRSHPW33MdavcumDIay-iDQkZzxnF047i829mUGJ7I',
                'sheet_name' => '単語',
                'sheet_range' => 'A2:H1000',
                'route' => 'vocabulary'
            ],
            [
                'sheet_id' => '1HCRSHPW33MdavcumDIay-iDQkZzxnF047i829mUGJ7I',
                'sheet_name' => '副詞',
                'sheet_range' => 'A2:F1000',
                'route' => 'adverb'
            ],
            [
                'sheet_id' => '1HCRSHPW33MdavcumDIay-iDQkZzxnF047i829mUGJ7I',
                'sheet_name' => '語形成',
                'sheet_range' => 'A2:F1000',
                'route' => 'word_formation'
            ],
            [
                'sheet_id' => '1HCRSHPW33MdavcumDIay-iDQkZzxnF047i829mUGJ7I',
                'sheet_name' => '文法',
                'sheet_range' => 'A2:H1000',
                'route' => 'grammar'
            ],
            [
                'sheet_id' => '1XdPgMvNI1VJY4X9NXD4fMbmg6USx9KLkCz14FUWRNpg',
                'sheet_name' => 'Dic',
                'sheet_range' => 'A3:N1000',
                'route' => 'kanji'
            ],
        ];
        SheetInfo::insert($data);
    }
}
