<?php

namespace App\Models;

use App\Enums\User\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Follow;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'role',
        'permission_level',
        'user_id',
        'education',
        'location',
        'note'
    ];

    const ROLE_MAP = [
        Role::ADMIN => 'admin',
        Role::LEARNER => 'learner',
        Role::TEACHER => 'teacher'
    ];
    
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getRoleNameAttribute()
    {
        return $this::ROLE_MAP[$this->role];
    }

    public function followers()
    {
        $followers = Follow::where('idol', $this->id)->get();
        $followerIds = $followers->pluck('follower')->toArray();
        $accounts = static::whereIn('id', $followerIds)->get();
        return $accounts;
    }

    public function following()
    {
        $following = Follow::where('follower', $this->id)->get();
        $followingIds = $following->pluck('idol')->toArray();
        $accounts = static::whereIn('id', $followingIds)->get();
        return $accounts;
    }

    public function numOfFollowers()
    {
        $numOfFollowers = Follow::where('idol', $this->id)->count();
        return $numOfFollowers;
    }

    public function numOfFollowing()
    {
        $numOfFollowing = Follow::where('follower', $this->id)->count();
        return $numOfFollowing;
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'owner_id', 'id');
    }
}
