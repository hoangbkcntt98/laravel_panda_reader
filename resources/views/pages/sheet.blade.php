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
        </div>
        <div class="card-body {{ $route }}_table">

            {{-- Minimal example / fill data using the component slot --}}
            @if (!$use_config)
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" striped hoverable bordered
                    with-buttons>
                    @foreach ($config['data'] as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td><span>{!! nl2br($cell) !!}</span></td>
                            @endforeach
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            @else
                <x-custom-datatable id="sheet_table" :heads="$heads" :config="$config" :filename="$route" striped hoverable with-buttons
                bordered scrollable  />
            @endif



        </div>
    </div>
@endsection
@section('js')
    <script>
        function makeHTML(filename) {
            var inputData = @json($raw_data);
            var route = @json($route);
            var html_url = @json(route('html.make', [
                'route' => $route
            ]));
            window.open(html_url, "_blank")
            console.log(route,inputData)
        }
    </script>
    {{-- <script src="/js/jquery.doubleScroll.js"></script> --}}
@stop
