<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $employee->name }}</p>
</div>

<!-- Mobile Field -->
<div class="col-sm-12">
    {!! Form::label('mobile', 'Mobile:') !!}
    <p>{{ $employee->mobile }}</p>
</div>

<!-- Role Field -->
<div class="col-sm-12">
    {!! Form::label('role', 'Role:') !!}
    <p>{{ $employee->role }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p><img src="{{ asset('storage/uploads/'.$employee->image)  }}"width="200"></p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $employee->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $employee->updated_at }}</p>
</div>

