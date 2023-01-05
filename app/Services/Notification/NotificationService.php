<?php

namespace App\Services\Notification;

use App\Models\Notification;

class NotificationService{

    private $model = Notification::class;
    
    public function create(array $notification)
    {
        $this->model::create($notification);
    }

    public function all()
    {
        $notifications = $this->model::all();
        $notifications = $notifications->sortByDesc('created_at');
        return $notifications;
    }

    public function makeDropdownNotifications($notifications)
    {
        $dropdownHtml = '';

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";
    
            $time = "<span class='float-right text-muted text-sm'>
                       {$not['time']}
                     </span>";
    
            $dropdownHtml .= "<a href='notifications/{$not['id']}' class='dropdown-item panda-dropdown-item'>
                                <div class = 'panda-dropdown-item icon'>
                                {$icon}
                                </div>
                                <div class = 'panda-dropdown-item text'>
                                {$not['text']}
                                </div>
                                <div class = 'panda-dropdown-item time'>
                                {$time}
                                </div>
                              </a>";
    
            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }
        return $dropdownHtml;

    }
}