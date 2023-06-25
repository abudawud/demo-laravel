{!! Form::token() !!}
<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label("name", "Name") !!}
        {!! Form::text("name", $record?->name, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("description", "Description") !!}
        {!! Form::text("description", $record?->description, ["class" => "form-control"]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::label("is_active", "Is Active") !!}
        {!! Form::text("is_active", $record?->is_active, ["class" => "form-control"]) !!}
    </div>
</div>
