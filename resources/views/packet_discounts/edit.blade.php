@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Packet Discount</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($packetDiscount, ['route' => ['packetDiscounts.update', $packetDiscount->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('packet_discounts.fields_edit')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'savePageButton']) !!}
                {{-- <a href="{{ route('packetDiscounts.index') }}" class="btn btn-default">Cancel</a> --}}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
