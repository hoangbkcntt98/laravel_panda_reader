@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notifications</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="timeline">
                    @foreach ($groupByDayNotifications as $date => $notifications)
                        <div class="time-label">
                            <span class="bg-red">{{$date}}</span>
                        </div>

                        @foreach ($notifications as $noti)
                            <div>
                                <i class="{{ $noti->icon }}"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i>
                                        {{ getNotificationTime($noti->created_at) }}</span>
                                    <h3 class="timeline-header"><a href="#">{{ $noti->type_name }}</a> </h3>
                                    <div class="timeline-body">
                                        {{ $noti->content }}
                                    </div>
                                    <div class="timeline-footer">
                                        @if (!$noti->isReaded())
                                            <a class="btn btn-primary btn-sm" href="/notifications/marked/{{$noti->id}}">Mark as Read</a>
                                        @endif
                                        
                                        <a class="btn btn-danger btn-sm" href="/notifications/delete/{{$noti->id}}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach


                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
