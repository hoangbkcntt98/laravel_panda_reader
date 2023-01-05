<?php

namespace App\Models;

use App\Enums\Notification\Status;
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

    const NOTIFICATION_TYPE_MAP = [
        Type::AUTH => 'Authentication',
        Type::SYNC => 'Synchronization',
        Type::EXPORT => 'Export'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function getTypeNameAttribute()
    {
        return $this::NOTIFICATION_TYPE_MAP[$this->type];
    }

    public function getIconAttribute()
    {
        return $this::NOTIFICATION_ICON_MAP[$this->type];
    }

    public function isReaded()
    {
        return $this->status == Status::READED;
    }
}
