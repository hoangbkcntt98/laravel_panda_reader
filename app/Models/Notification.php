<?php

namespace App\Models;

use App\Enums\Notification\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'status',
        'type',
        'read_permission',
        'created_at',
        'id'
    ];

    const NOTIFICATION_ICON_MAP = [
        Type::AUTH => 'fas fa-user',
        Type::SYNC => 'fas fa-sync',
        Type::EXPORT => 'fas fa-file-export'
    ];

    public function getIconAttribute()
    {
        return $this::NOTIFICATION_ICON_MAP[$this->type];
    }

}
