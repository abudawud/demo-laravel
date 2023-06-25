<form class="form-crud" action="{{ route('ms-barang.update', $record) }}" method="post">
    {!! Form::hidden('_method', 'PATCH') !!}
    @include('ms-barang.form')
</form>

