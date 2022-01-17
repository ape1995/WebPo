@extends('layouts.app')

@section('content')
    {{-- <section class="content-header"> --}}
        <div class="container-fluid p-1 mx-3">
            <h5>Order - {{ $salesOrder->order_nbr }}</h5>
        </div>
    {{-- </section> --}}

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            <div class="card-body">
                <div class="m-2 text-center">
                    
                    @if ($salesOrder->status == 'C')
                        <span class="text-danger rounded p-1">Canceled</span>
                    @endif

                    @if ($salesOrder->status == 'B')
                        <span class="text-danger rounded p-1">Order Rejected Because : {{ $salesOrder->rejected_reason }}</span>
                    @endif
                </div>
                {{-- <div class="col-md-12 text-right mb-3">
                    <span class="text-light bg-info rounded p-1">{{ $salesOrder->status }}</span>
                </div> --}}
                <div class="row mb-3">
                    @include('sales_orders.show_fields')
                </div>

                @include('sales_order_details.table')

            </div>

            <div class="card-footer">
                {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
                <a href="{{ route('salesOrders.printPdf', [$salesOrder->id]) }}" class="btn btn-outline-danger" id="btnPrint"><i class="fa fa-file-pdf"></i> Print</a>
                @if ($salesOrder->status == 'S')
                    @can('edit sales order')
                        <a href="{{ route('salesOrders.edit', [$salesOrder->id]) }}" class="btn btn-success" onclick="return confirm('Edit this order?')">Edit</a>
                    @endcan
                    @can('cancel sales order')
                        <a href="{{ route('salesOrders.cancelOrder', [$salesOrder->id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure to cancel this order?')">Cancel Order</a>
                    @endcan
                    @can('submit sales order')
                        <a href="{{ route('salesOrders.submitOrder', [$salesOrder->id]) }}" class="btn btn-info" onclick="return confirm('Submit Order?')">Submit Order</a>
                    @endcan
                @endif
                @if ($salesOrder->status == 'R')
                    @can('process sales order')
                        <a href="{{ route('salesOrders.processOrder', [$salesOrder->id]) }}" class="btn btn-primary"  onclick="return confirm('Process Order?')">Process</a>
                    @endcan
                    @can('reject sales order')
                        <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalReject">Reject</a>
                        <!-- Modal -->
                        <div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <form action="{{ route('salesOrders.rejectOrder') }}" method="post">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #c61325">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Reject Order Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 mb-1">
                                                    {!! Form::label('reason', 'Reason:') !!}
                                                    <input type="hidden" name="id_order" value="{{ $salesOrder->id }}">
                                                    {!! Form::textarea('reason', null, ['class' => 'form-control', 'required' => true, 'rows' => 2]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="Confirm">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endcan
                @endif
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        $(document).ready(function() {
            $("#btnPrint").click(function() {
                // disable button
                $(this).prop("disabled", true);
                // add spinner to button
                $(this).html(
                    '<span class="spinner-border spinner-border-sm" role="status"></span><span class="sr-only">Loading...</span>'
                );

                setTimeout(function(){
                    $(this).prop("disabled", false);
                    $(this).html(
                        '<i class="fa fa-file-pdf"></i> Print'
                    );
                },8000);
            });
        });
    </script>
@endpush