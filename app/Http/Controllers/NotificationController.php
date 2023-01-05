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

    public function show(Request $request)
    {
        $notifications = $this->service->all();
        $notifications = collect($notifications)->groupBy(function($item){
            return Carbon::parse($item->created_at)->format('Y/m/d');
        });
        return view('pages.notifications.show' ,[   
            'groupByDayNotifications' => $notifications
        ]);
    }

    public function read(Request $request, $id)
    {
        $notification = $this->service->getNotification($id);
        $this->service->marked($id);
        return view('pages.notifications.read', [
            'noti' => $notification
        ]);
    }

    public function delete(Request $request, $id)
    {
        $this->service->delete($id);
        return redirect()->back();
    }

    public function marked(Request $request, $id)
    {
        $this->service->marked($id);
        return redirect()->back();
    }

    
}
