@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notification</h1>
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
                                
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
