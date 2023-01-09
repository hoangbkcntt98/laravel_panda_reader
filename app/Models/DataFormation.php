<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFormation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'row',
        'column',
        'value',
        'material_id'
    ];
}
