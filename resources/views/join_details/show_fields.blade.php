<!-- Employee Id Field -->
<div class="col-sm-12">
    {!! Form::label('employee_id', 'Employee Id:') !!}
    <p>{{ $joinDetail['employee']['name'] }}</p>
</div>

<!-- Join Date Field -->
<div class="col-sm-12">
    {!! Form::label('join_date', 'Join Date:') !!}
    <p>{{ $joinDetail->join_date }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $joinDetail->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $joinDetail->updated_at }}</p>
</div>

