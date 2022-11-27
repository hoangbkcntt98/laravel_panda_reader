<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanji extends Model
{
    use HasFactory, Queryable;
    protected $table = 'kanji';
    protected $fillable = [
        'no',
        'level',
        'chapter_no',
        'chapter_name',
        'kanji',
        'meaning',
        'vn_cn',
        'reading',
        'how_to_remember',
        'word',
        'sentence',
        'practive',
        'homonym',
    ];

    const DISPLAY_COLUMNS = [
        'no',
        // 'level',
        'chapter_no',
        'chapter_name',
        'kanji',
        'meaning',
        'vn_cn',
        'reading',
        // 'how_to_remember',
        'word',
        'sentence',
        'practive',
        'homonym',
    ];

    const COLUMN_MAP = [
        'no' => 0,
        'level' => 1,
        'chapter_no' => 2,
        'chapter_name' => 3,
        'kanji' => 4,
        'meaning' => 5,
        'vn_cn' => 6,
        'reading' => 7,
        'how_to_remember' => 8,
        'word' => 9,
        'sentence' => 10,
        'practive' => 11,
        'homonym' => 13,
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'no' => 'integer',
    ];
}
