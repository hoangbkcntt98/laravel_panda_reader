<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'sheet_id',
        'sheet_name',
        'sheet_range',
        'css',
        'html'
    ];

    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }
}
