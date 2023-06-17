<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::select('name', $employee->pluck('name','id'), null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Attendance Field -->
<div class="form-group col-sm-10">
    {!! Form::label('attendance', 'Attendance:') !!}
    <label class="form-check">
        {!! Form::radio('attendance', 'Present', null, ['class' => 'form-check-input']) !!} Present
    </label>
    <label class="form-check">
        {!! Form::radio('attendance', 'Absent', null, ['class' => 'form-check-input']) !!} Absent
    </label>
</div>

<!-- Reason Field -->
<div class="form-group col-sm-6" id="reason">
    {!! Form::label('reason', 'Reason:') !!}
    {!! Form::text('reason', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Field -->
<div class="form-group col-sm-3">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date']) !!}
</div>

@push('page_scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
    $(document).ready(function() {
        // Show/hide the reason field based on the selected attendance
        $('#reason').hide();
        $('input[name="attendance"]').on('change', function() {
            if ($(this).val() === 'Absent') {
                $('#reason').show();
                $('#reason input').attr('required', '');
            } else {
                $('#reason').hide();
                $('#reason input').removeAttr('required');
            }
        });

        // Initialize the datepicker plugin
        $('#date').datepicker({
            // Restrict date selection to not allow dates behind the current date
            dateFormat: 'yy-mm-dd' // Set the desired date format
        });
    });
</script>
@endpush
