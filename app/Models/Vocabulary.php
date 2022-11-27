<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory, Queryable;
    protected $table = 'vocabulary';

    protected $fillable = [
        'no',
        'chapter_no',
        'chapter_name',
        'word',
        'reading',
        'meaning',
        'sentence',
        'related_kanji',
    ];

    const DISPLAY_COLUMNS = [
        'no',
        'chapter_no',
        'chapter_name',
        'word',
        'reading',
        'meaning',
        'sentence',
        'related_kanji',
    ];

    const COLUMN_MAP = [
        'no' => 0,
        'chapter_no' => 1,
        'chapter_name' => 2,
        'word' => 3,
        'reading' => 4,
        'meaning' => 5,
        'sentence' => 6,
        'related_kanji' => 7,
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
