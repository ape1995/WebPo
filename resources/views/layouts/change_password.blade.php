<!-- Modal -->
<div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('updatePassword') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header text-light" style="background-color: #c61325">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 mb-1">
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('current_password', 'Current Password:') !!}
                            </div>
                            <div class="col-8">
                                {!! Form::password('current_password', ['class' => 'form-control', 'required' => true]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-1">
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('new_password', 'New Password:') !!}
                            </div>
                            <div class="col-8">
                                {!! Form::password('new_password', ['class' => 'form-control', 'required' => true]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-1">
                        <div class="row">
                            <div class="col-4">
                                {!! Form::label('confirm_password', 'Confirm Password:') !!}
                            </div>
                            <div class="col-8">
                                {!! Form::password('confirm_password', ['class' => 'form-control', 'required' => true]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Update Password">
                </div>
            </div>
        </form>
    </div>
</div>