@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Document</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Document</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @foreach ($documents as $doc)
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">{{ $doc->topic }}</h4>
                            </div>
                            @php
                                $materials = $doc->materials->chunk(5);
                            @endphp

                            <div class="card-body">
                                @foreach ($materials as $material_group)
                                    <div class="col-sm-12" style="display: flex; gap:2em;padding-bottom:2em">
                                        @foreach ($material_group as $mat)
                                            <div class="filtr-item col-sm-2 panda-material-item" data-category="1"
                                                data-sort="white sample">
                                                <a href="/materials/{{ $mat->id }}" data-toggle="lightbox"
                                                    data-title="sample 1 - white">
                                                    <img src="/image/spread.png" class="img-fluid mb-2" alt="white sample"
                                                        style="border-bottom:1px solid black;">
                                                </a>
                                                <div style="display: flex; align-items:center; justify-content:center">
                                                    <a href="/materials/{{ $mat->id }}"
                                                        style="text-align: center">{{ $mat->sheet_name }}</a>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </section>
@endsection
