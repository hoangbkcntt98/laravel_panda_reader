@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create new sheet</h1>
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
        <form action="{{ route('materials.store') }}" method="POST" id="sheetCreateForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>
                            {{-- <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Sheet ID</label>
                                <input type="text" name="sheet_id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputName">Sheet Name</label>
                                <input type="text" name="sheet_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputName">Sheet Range</label>
                                <input type="text" name="sheet_range" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Document</label>
                                <select id="inputStatus" class="form-control custom-select" name="document_id">
                                    @foreach ($documents as $item)
                                        <option value="{{ $item->id }}">{{ $item->topic }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Columns</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="column-container">
                                <div class="row">
                                    <div class="w-2"><strong>Column</strong></div>
                                    <div class="w-4"><strong>Column Name</strong></div>
                                    <div class="w-2"><strong>Is Skipped?</strong></div>
                                    <div class="w-2"><strong>Is Custom?</strong></div>
                                </div>
                                <div class="row column-item">
                                    <div class="w-2">
                                        <div class="form-group">
                                            <x-adminlte-input name="column[]" value="0"  class="column_no" type="number"/>
                                        </div>
                                    </div>
                                    <div class="w-4">
                                        <x-adminlte-input name="column_name[{{ 0 }}]" />
                                    </div>
                                    <div class="w-2">
                                        <div class="form-group flex-content-center">
                                            @include('components.form.checkbox', [
                                                'name' => 'skipped[]',
                                                'isChecked' => false,
                                            ])
                                        </div>
                                    </div>
                                    <div class="w-2">
                                        <div class="form-group flex-content-center">
                                            @include('components.form.checkbox', [
                                                'name' => 'custom[]',
                                                'isChecked' => false,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding: 4px;display:flex;gap:10px">
                                <x-adminlte-button class="btn-flat btn-sm" onclick="createNewColumn()" label="New"
                                    theme="success" icon="fas fa-plus" />
                                <x-adminlte-button class="btn-flat btn-sm" onclick="deleteColumn()" label="Delete"
                                    theme="danger" icon="fas fa-trash" />
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Template</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="html">HTML</label>
                                <x-adminlte-text-editor name="html" />
                            </div>
                            <div class="form-group">
                                <label for="css">CSS</label>
                                <x-adminlte-text-editor name="css" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
        <div class="row" style="padding: 3%">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Create" class="btn btn-success float-right" onclick="createSheet()">
            </div>
        </div>
        <div id="new-column-format">
            <div class='row column-item new-column-format'>
                <div class='w-2'>
                    <div class='form-group'>
                        <div class='form-group'>
                            <div class='input-group'>
                                <input id='column' name='column[]' value='0' class='form-control column_no' type="number"
                                    >
                            </div>
                        </div>
                    </div>
                </div>
                <div class='w-4'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input id='column_name[]' name='column_name[]' class='form-control'>
                        </div>
                    </div>
                </div>
                <div class='w-2'>
                    <div class='form-group flex-content-center'>
                        <div class='icheck-primary d-inline'>
                            <input type='checkbox' name='skipped[]' id="skipped[]" class="add-skipped">
                            <label for='skipped' class="add-skipped-label">
                            </label>
                        </div>
                    </div>
                </div>
                <div class='w-2'>
                    <div class='form-group flex-content-center'>
                        <div class='icheck-primary d-inline'>
                            <input type='checkbox' name='custom[]' id="custom[]" class="add-custom">
                            <label for='custom' class="add-custom-label">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection

@section('js')
    <script>
        function createSheet() {
            $('#sheetCreateForm input[type="checkbox"]').each(function() {
                var checkbox_this = $(this);
                if (checkbox_this.is(":checked") == true) {
                    checkbox_this.attr('value', '1');
                } else {
                    checkbox_this.prop('checked', true);
                    //DONT' ITS JUST CHECK THE CHECKBOX TO SUBMIT FORM DATA    
                    checkbox_this.attr('value', '0');
                }
            });
            $('#sheetCreateForm').submit();
        }

        function createNewColumn() {
            var divColumnItem = $("#new-column-format");
            var newLastColumn = $('#new-column-format .column_no');

            var addSkipped = $('#new-column-format .add-skipped');
            var addSkippedLabel = $('#new-column-format .add-skipped-label');

            var addCustom = $('#new-column-format .add-custom');
            var addCustomLabel = $('#new-column-format .add-custom-label');

            var addColumnItem = $('#new-column-format .row .column-item');


            console.log(newLastColumn)
            var lastColumn = $('.row.column-item').not('.new-column-format').last();
            var lastNum = $('#new-column-format .column_no').val();
            var newNum = parseInt(lastNum) + 1;
            newLastColumn.attr('value', newNum);
            addSkipped.attr('name', 'skipped[]')
            addSkipped.attr('id', "skipped_" + newNum)
            addSkippedLabel.attr('for', "skipped_" + newNum)

            addCustom.attr('id', "custom_" + newNum)
            addCustomLabel.attr('for', "custom_" + newNum)

            $('.column-container').append(divColumnItem.html());
        }

        function deleteColumn() {
            var lastColumn = $('.column-container > .row.column-item').last();
            console.log(lastColumn)
            lastColumn.remove();
            var divColumnItem = $("#new-column-format");
            var newLastColumn = $('#new-column-format .column_no');
            var addSkipped = $('#new-column-format .add-skipped');
            var addSkippedLabel = $('#new-column-format .add-skipped-label');
            var addCustom = $('#new-column-format .add-custom');
            var addCustomLabel = $('#new-column-format .add-custom-label');
            var addColumnItem = $('#new-column-format .row .column-item');
            var lastNum = $('#new-column-format .column_no').val();
            var newNum = parseInt(lastNum) - 1;
            newLastColumn.attr('value', newNum);
            addSkipped.attr('name', 'skipped[]')
            addSkipped.attr('id', "skipped_" + newNum)
            addSkippedLabel.attr('for', "skipped_" + newNum)
            addCustom.attr('id', "custom_" + newNum)
            addCustomLabel.attr('for', "custom_" + newNum)

        }
    </script>
@stop
