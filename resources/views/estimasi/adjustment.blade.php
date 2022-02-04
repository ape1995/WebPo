{!! Form::open(['route' => 'estimasi.store']) !!}
    <div class="d-flex justify-content-between">
        <input type="number" name="adjustment" id="adjustment" class="form-control col-6" required>
        <input type="submit" class="btn btn-success btn-sm col-4" name="submit" value="OK">
    </div>
{!! Form::close() !!}