{{-- Custom --}}
@php
    $min = 1;
    $max = count($data);
@endphp
<x-adminlte-modal id="modalCustom" title="HTML Export Setting" size="md" theme="teal" icon="fas fa-file-export"
    v-centered static-backdrop scrollable>
    <form action="{{ route('html.make') }}" method="GET" id="makeHtmlForm">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <x-adminlte-input name="from" label="From" placeholder="Enter No" type="number" igroup-size="sm"
                        min={{ $min }} max={{ $max }}>
                    </x-adminlte-input>
                </div>
            </div>
            <div class="col-sm-6">
                <x-adminlte-input name="to" label="To" placeholder="Enter No" type="number" igroup-size="sm"
                    min={{ $min }} max={{ $max }}>
                </x-adminlte-input>
            </div>
        </div>
        <input type="hidden" name="route" value="{{ $route }}">
    </form>

    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Make HTML" onclick="makeHTML('sync')" />
        <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
