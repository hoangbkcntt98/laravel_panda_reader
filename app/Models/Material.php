<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }
}
