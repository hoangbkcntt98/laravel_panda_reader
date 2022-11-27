{{-- Custom --}}
@php
    $options = $collection->pluck('no')->toArray();
    $min = [0];
    $max = [count($options)-1];
@endphp
<x-adminlte-modal id="modalCustom" title="HTML Export Setting" size="md" theme="teal"
    icon="fas fa-file-export" v-centered static-backdrop scrollable>
    <form action="{{route('html.make')}}" method="GET" id ="{{$route."_form"}}">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">From</label>
                    <x-adminlte-select name="from">
                        <x-adminlte-options :options="$options"
                            :selected="$min"/>
                    </x-adminlte-select>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="">To</label>
                <x-adminlte-select name="to">
                    <x-adminlte-options :options="$options"
                    :selected="$max"/>
                </x-adminlte-select>
            </div>
        </div>
        <input type="hidden" name="route" value="{{$route}}">
    </form>

    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Make HTML" onclick="makeHTML('sync')"/>
        <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal"/>
    </x-slot>
</x-adminlte-modal>
