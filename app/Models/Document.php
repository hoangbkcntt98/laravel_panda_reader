<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'topic',
        'image'
    ];

    public function materials()
    {
        return $this->hasMany(Material::class, 'document_id');
    }
}
