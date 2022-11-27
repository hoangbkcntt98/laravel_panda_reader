@extends('layouts.app')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ trans('pages.' . $route) }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ trans('pages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('pages.' . $route) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <x-adminlte-button class="btn-md" onclick="window.location='{{ route($route . '.sync') }}'" label="Sync"
                theme="outline-primary" icon="fas fa-lg fa-sync" />
                
            @include('components.custom-modal', [
                'data' => $config['data']
            ])
        </div>
        <div class="card-body {{ $route }}_table">
            <x-custom-datatable id="sheet_table" :heads="$heads" :config="$config" :filename="$route" striped hoverable
                with-buttons bordered scrollable />
        </div>
    </div>
@endsection
@section('js')
    <script>
        function makeHTML(filename) {
            var inputData = @json($raw_data);
            var route = @json($route);
            var from = $('#'+route+"_form :input[name='from']").val();
            var to = $('#'+route+"_form :input[name='to']").val();
            var form = $('#'+route+"_form");
            console.log(from)
            var html_url = @json(route('html.make', [
                    'route' => $route,
                ]));
            window.open(html_url+'&from='+from+'&to='+to, "_blank")
            console.log(route, inputData)
        }
    </script>
    {{-- <script src="/js/jquery.doubleScroll.js"></script> --}}
@stop
