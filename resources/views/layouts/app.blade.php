@extends('adminlte::page')

@section('title', 'Panda Reader')

@section('content_header')

@stop

@section('content')

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    {{-- <script>
        function makeHTML(filename) {
            var inputData = @json($raw_data);
            var route = @json($route);
            var html_url = @json(route('html.review'));
            window.open(html_url, "_blank")
            console.log(route,inputData)
        }
    </script> --}}
    {{-- <script src="/js/jquery.doubleScroll.js"></script> --}}
@stop
