{{-- Custom --}}
<x-adminlte-modal id="documentCreate" title="Create A New Document" size="md" theme="teal" icon="fas fa-plus"
    v-centered static-backdrop scrollable>
    <form action="{{ route('documents.store') }}" method="POST" id="documentCreateForm">
        @csrf
        <div class="row">
            <x-adminlte-input name="topic" label="Topic" placeholder="Topic" fgroup-class="col-md-12"/>
        </div>
        <div class="row">
            <x-adminlte-input-file name="image" label="Image" placeholder="Choose a file..." fgroup-class="col-md-12"/>
        </div>

    </form>

    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Create" onclick="createDocument()" />
        <x-adminlte-button theme="danger" label="Cancel" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

@section('js')
    <script>
        function createDocument() {
            $('#documentCreateForm').submit();
        }
    </script>
@stop
