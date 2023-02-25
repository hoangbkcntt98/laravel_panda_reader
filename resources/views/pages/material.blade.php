@extends('layouts.app')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('content')
@php
    $name = $sheet_information->sheet_name;
    $document = $sheet_information->document;
    $documentName = $document->topic;
@endphp
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $documentName.'/'.$name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">{{ trans('pages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="/documents">{{ trans('pages.document') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('pages.material' ) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <x-adminlte-button class="btn-md" onclick="window.location='{{ $route . '/sync' }}'" label="Sync"
                theme="outline-primary" icon="fas fa-lg fa-sync" />
            <x-adminlte-button class="btn-md" onclick="window.open('{{$sheet_url}}')" label="SpreadSheet"
            theme="outline-primary" icon="fas fa-lg fa-file-excel" />

            @include('pages.material.make_html_config', [
                'data' => $config['data'],
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
            var from = $("#makeHtmlForm :input[name='from']").val();
            var to = $("#makeHtmlForm :input[name='to']").val();
            var form = $('#makeHtmlForm').length;

            var html_url = @json(route('materials.makeHtml', [
                    'id' => $id,
                ]));
            window.open(html_url + '?from=' + from + '&to=' + to, "_blank")
        }
    </script>
@stop
