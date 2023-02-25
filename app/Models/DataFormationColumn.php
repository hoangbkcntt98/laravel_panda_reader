<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFormationColumn extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_id',
        'column',
        'column_name',
        'is_skipped',
        'is_custom'
    ];
}
