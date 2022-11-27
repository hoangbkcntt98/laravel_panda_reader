<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adverb extends Model
{
    use HasFactory, Queryable;

    protected $table = "adverb";

    protected $fillable = [
        'no',
        'chapter_name',
        'topic_name',
        'word',
        'meaning',
        'sentence',
    ];

    const DISPLAY_COLUMNS = [
        'no',
        'chapter_name',
        'topic_name',
        'word',
        'meaning',
        'sentence',
    ];

    const COLUMN_MAP = [
        'no' => 0,
        'chapter_name' => 1,
        'topic_name' => 2,
        'word' => 3,
        'meaning' => 4,
        'sentence' => 5,
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
