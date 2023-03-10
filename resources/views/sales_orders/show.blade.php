@extends('layouts.app')

@section('content')
    {{-- <section class="content-header"> --}}
        <div class="container-fluid p-1 mx-3">
            <h5>{{ trans('sales_order.order') }} - {{ $salesOrder->order_nbr }}</h5>
        </div>
    {{-- </section> --}}

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-body">
                <a href="{{ route('salesOrders.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                <div class="m-2 text-center">
                    
                    @if ($salesOrder->status == 'C')
                        <span class="text-danger rounded p-1">Canceled</span>
                    @elseif ($salesOrder->status == 'B')
                        <h4 class="text-danger bg-light rounded p-1">Order Rejected : {{ $salesOrder->rejected_reason }}</h4>
                    @else

                        @if ($salesOrder->order_type == 'G')
                            @if ($freeGimmick != null && $qtyGimmick < 1)
                                <h5 class="text-warning bg-light rounded p-1 mb-3">Total order belum memenuhi syarat untuk mendapatkan {{ $freeGimmick->free_descr }}</h5>
                            @endif
                            @if ($freeGimmick != null && $qtyGimmick > 0)
                                <h4 class="text-success bg-light rounded p-1">Free {{ $qtyGimmick }} pcs {{ $freeGimmick->free_descr }}</h4>
                                @if ($salesOrder->status == 'S')
                                    <small class="text-info">*Submit pesanan ini untuk mendapatkan free item.</small>
                                @endif
                            @endif
                        @endif

                        @if ($salesOrder->order_type == 'P')
                            @if ($freeProduct != null || !empty($freeProduct))
                                {{-- <h4 class="text-success bg-light rounded p-1">Free : <h4> --}}
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($freeProduct as $item)
                                    @php
                                        $freeQty = floor($item->qty / $item->qty_buy * $item->qty_free);
                                        $count+=$freeQty
                                    @endphp
                                    @if ($freeQty > 0)                          
                                        <h6>Free {{ $item->free_descr }} {{ $freeQty }} pcs</h6>
                                    @endif
                                @endforeach
                                @if ($salesOrder->status == 'S')
                                    @if ($count > 0)
                                        <small class="text-info">*Submit pesanan ini untuk mendapatkan free item.</small>
                                    @endif
                                @endif
                            @endif
                        @endif

                    @endif

                </div>
                @if ($salesOrder->status == 'R' || $salesOrder->status == 'P' || $salesOrder->status == 'B' || $salesOrder->status == 'C')
                    <div class="text-right m-2">
                        <a href="{{ route('salesOrders.printPdf', [$salesOrder->id]) }}" class="btn btn-sm btn-outline-danger" id="btnPrint"><i class="fa fa-file-pdf"></i> {{ trans('sales_order.btn_print') }}</a>
                        @can('create sales order')
                            @if ($salesOrder->order_type != 'C')
                            <a href="{{ route('salesOrders.reOrder', [$salesOrder->id]) }}" class="btn btn-sm btn-outline-info" onclick="return confirm('{{ trans('sales_order.question_reorder') }}')"><i class="fas fa-redo-alt"></i> {{ trans('sales_order.reorder') }}</a>
                            @endif
                        @endcan
                    </div>
                @endif

                <div class="row mb-3">
                    @include('sales_orders.show_fields')
                </div>

                @include('sales_order_details.table')

                @if ($salesOrder->status == 'R')
                <div class="card" @can('hide price sales order') style="visibility: collapse" @endcan>
                    <div class="card-body p-1 m-1 text-right">
                        <a class="btn btn-info text-light m-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            {{ trans('sales_order.btn_upload_tf') }}
                        </a>
                        <div class="collapse" id="collapseExample">
                            <form action="{{ route('salesOrders.uploadAttachment') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5 my-2">
                                        <input type="hidden" name="id_order" value="{{ $salesOrder->id }}">
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="">- Type Lampiran -</option>
                                            <option value="Bukti Transfer">Bukti Transfer</option>
                                            <option value="PO">PO</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5 my-2">
                                        <input type="file" name="file" id="file" class="form-control" accept="image/png, image/gif, image/jpeg" required>
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="submit" class="btn btn-primary" value="Upload">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                @include('attachments.table')

            </div>

            <div class="card-footer">

                @if ($salesOrder->status == 'S')
                    @can('edit sales order')
                        <a href="{{ route('salesOrders.edit', [$salesOrder->id]) }}" class="btn btn-success p-1" onclick="return confirm('{{ trans('sales_order.question_edit') }}')">{{ trans('sales_order.btn_edit') }}</a>
                    @endcan
                    @can('cancel sales order')
                        <a href="{{ route('salesOrders.cancelOrder', [$salesOrder->id]) }}" class="btn btn-danger p-1" onclick="return confirm('{{ trans('sales_order.question_cancel') }}')">{{ trans('sales_order.btn_cancel') }}</a>
                    @endcan
                    @can('submit sales order')
                        @if ($parameterNow >= $parameter->parameter_hour)
                            <a href="{{ route('salesOrders.submitOrder', [$salesOrder->id]) }}" class="btn btn-info p-1" onclick="return confirm('{{ trans('sales_order.question_submit_2') }}')">{{ trans('sales_order.btn_submit_order') }}</a>
                        @else
                            <a href="{{ route('salesOrders.submitOrder', [$salesOrder->id]) }}" class="btn btn-info p-1" onclick="return confirm('{{ trans('sales_order.question_submit') }}')">{{ trans('sales_order.btn_submit_order') }}</a>
                        @endif
                    @endcan
                @endif
                @if ($salesOrder->status == 'R')
                    @can('process sales order')
                        <a href="{{ route('salesOrders.processOrder', [$salesOrder->id]) }}" class="btn btn-primary btn-sm"  onclick="return confirm('{{ trans('sales_order.question_process') }}')">{{ trans('sales_order.btn_process_order') }}</a>
                    @endcan
                    @can('reject sales order')
                        <a type="button" class="btn btn-danger btn-sm text-light" data-toggle="modal" data-target="#modalReject">{{ trans('sales_order.btn_reject_order') }}</a>
                        <!-- Modal -->
                        <div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalReject" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <form action="{{ route('salesOrders.rejectOrder') }}" method="post">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #c61325">
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('sales_order.question_reject') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 mb-1">
                                                    {!! Form::label('reason', trans('sales_order.reason')) !!}
                                                    <input type="hidden" name="id_order" value="{{ $salesOrder->id }}">
                                                    {!! Form::textarea('reason', null, ['class' => 'form-control', 'required' => true, 'rows' => 2]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="{{ trans('sales_order.confirm') }}">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endcan
                @endif
                @if ($salesOrder->status == 'P')
                    @can('reject sales order')
                        <a type="button" class="btn btn-danger btn-xs text-light" data-toggle="modal" data-target="#modalReject">{{ trans('sales_order.btn_reject_order') }}</a>
                        <!-- Modal -->
                        <div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalReject" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <form action="{{ route('salesOrders.rejectOrder') }}" method="post">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #c61325">
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('sales_order.question_reject') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 mb-1">
                                                    {!! Form::label('reason', trans('sales_order.reason')) !!}
                                                    <input type="hidden" name="id_order" value="{{ $salesOrder->id }}">
                                                    {!! Form::textarea('reason', null, ['class' => 'form-control', 'required' => true, 'rows' => 2]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="{{ trans('sales_order.confirm') }}">
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

                window.setTimeout(function(){
                    $(this).prop("disabled", false);
                    $(this).html(
                        '<i class="fa fa-file-pdf"></i> Print'
                    );
                },5000);
            });

        });
    </script>
@endpush