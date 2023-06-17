<!-- Employee Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employee_id', 'Employee Id:') !!}
    {!! Form::select('employee_id',$employee->pluck('name', 'id'), null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Join Date Field -->
<div class="form-group col-sm-2">
    {!! Form::label('join_date', 'Join Date:') !!}
    {!! Form::date('join_date', null, ['class' => 'form-control','id'=>'join_date']) !!}
</div>
@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#join_date').datepicker();
        });
    </script>
@endpush