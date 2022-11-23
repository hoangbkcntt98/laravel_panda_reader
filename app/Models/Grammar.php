<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grammar extends Model
{
    use HasFactory, Queryable;

    protected $table = 'grammar';

    protected $fillable = [
        'no',
        'word',
        'sentence',
        'meaning',
        'connection',
        'usage',
        'warning',
        'related_grammar',
    ];

    const DISPLAY_COLUMNS = [
        'no',
        'word',
        'sentence',
        'meaning',
        'connection',
        'usage',
        'warning',
        'related_grammar',
    ];

    const COLUMN_MAP = [
        'no' => 0,
        'word' => 1,
        'sentence' => 2,
        'meaning' => 3,
        'connection' => 4,
        'usage' => 5,
        'warning' => 6,
        'related_grammar' => 7,
    ];
}
