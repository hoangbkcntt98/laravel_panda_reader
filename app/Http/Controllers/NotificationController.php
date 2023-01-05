<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = app('service.notification');    
    }

    public function get(Request $request)
    {
        $notifications = $this->service->all();
        $handledNotifications = [];
        foreach($notifications as $notification){
            $time = getNotificationTime($notification->created_at);
            $handleNoti = [
                'icon' => $notification->icon,
                'text' => $notification->content,
                'time' => $time,
                'id' => $notification->id
            ];
            $handledNotifications [] = $handleNoti;
        }
        $dropdownHtml = $this->service->makeDropdownNotifications($handledNotifications);
        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }
    
}
