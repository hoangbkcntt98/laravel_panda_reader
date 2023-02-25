{{-- Custom --}}
<x-adminlte-modal id="documentEdit" title="Edit Document" size="md" theme="teal" icon="fas fa-plus" v-centered
    static-backdrop scrollable>
    <form action="{{ route('documents.edit', ['id' => $doc->id]) }}" method="POST" id="documentEditForm">
        @csrf
        <div class="row">
            <x-adminlte-input name="topic" label="Topic" placeholder="Topic"  value="{{$doc->topic}}"
                />
        </div>
        <div class="row">
            <x-adminlte-input-file name="image" label="Image" placeholder="Choose a file..." 
                 />
        </div>

    </form>

    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="warning" label="Edit" onclick="editDocument()" />
        <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

@section('js')
    <script>
        function editDocument() {
            $('#documentEditForm').submit();
        }
    </script>
@stop
