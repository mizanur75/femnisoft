@extends('layouts.app')
@section('title','All Payment')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
    <style>

        select.form-control:not([size]):not([multiple]) {
            height: 1.8rem;
            width: 3rem;
        }
    </style>
@endpush


@section('content')
    <div class="row">
        <!-- Widget Item -->
        <div class="col-md-3">
            <div class="widget-area proclinic-box-shadow color-blue">
                <div class="widget-left">
                    <span class="fa fa-calculator radius"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">Total</h4>
                    <span class="numeric">{{$total}}</span>
                </div>
            </div>
        </div>
        <!-- /Widget Item -->

        <div class="col-md-3">
            <div class="widget-area proclinic-box-shadow color-yellow">
                <div class="widget-left">
                    <span class="fa fa-calculator radius"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">Payable</h4>
                    <span class="numeric">{{$pay_amount}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-area proclinic-box-shadow color-green">
                <div class="widget-left">
                    <span class="fa fa-calculator radius"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">Paid Amount</h4>
                    @php($paid_total = 0)
                    @foreach($paid_amount as $amount)
                        @php($paid_total += $amount->amount)
                    @endforeach
                    <span class="numeric">{{$paid_total}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-area proclinic-box-shadow color-red">
                <div class="widget-left">
                    <span class="fa fa-calculator radius"></span>
                </div>
                <div class="widget-right">
                    <h4 class="wiget-title">Due Amount</h4>
                    <span class="numeric">{{$pay_amount - $paid_total}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Widget Item -->
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                @if($errors->any())
                    <div class="col-md-12">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $error }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                    <button class="btn btn-padding btn-sm btn-primary pull-right" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add New</button>
                    <h3 class="widget-title">All Payment</h3>
                <div class="table-responsive">
                    <table id="tableId" class="table table-sm table-bordered table-striped">
                        <thead>
                        <tr class="text-center">
                            <th>#SL</th>
                            <th>ID</th>
{{--                            <th>Name</th>--}}
                            <th>Amount</th>
                            <th>From Acc.</th>
                            <th>Pay. Type</th>
                            <th>Tran. ID</th>
                            <th>Payment Date</th>
                            <th>Received Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payable_amount as $amount)
                            <tr class="text-center">
                                <td>{{$loop->index +1}}</td>
                                <td>{{$amount->id}}</td>
{{--                                <td>{{$amount->user->name}}</td>--}}
                                <td>{{$amount->amount}}</td>
                                <td>{{$amount->account_no}}</td>
                                <td>{{$amount->payment_type}}</td>
                                <td>{{$amount->transection_id}}</td>
                                <td>{{date('d M Y h:i a', strtotime($amount->created_at))}}</td>
                                <td>
                                    @if($amount->status == 1)
                                    {{date('d M Y h:i a', strtotime($amount->updated_at))}}
                                    @endif
                                </td>
                                <td>
                                    @if($amount->status == 0)
                                        <button type="button" class="btn btn-padding btn-sm btn-warning">Pending</button>
                                    @else
                                        <button type="button" class="btn btn-padding btn-sm btn-primary">Received</button>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Widget Item -->
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Input Amount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('agent.storepayment')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="" class="font-weight-bold">Amount:</label>
                        <input type="number" name="amount" class="form-control form-control-sm" placeholder="Enter Amount">
                        <label for="" class="font-weight-bold">Payment Type:</label>
                        <select name="payment_type" class="form-control form-control-sm" style="width: 100%;">
                            <option value="Bkash">Bkash</option>
                            <option value="Rocket">Rocket</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
                        <label for="" class="font-weight-bold">From Account:</label>
                        <input type="text" name="account_no" class="form-control form-control-sm" placeholder="Enter Your Account Number">
                        <label for="" class="font-weight-bold">Transection ID:</label>
                        <input type="text" name="transection_id" class="form-control form-control-sm" placeholder="Enter Transection ID">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-padding btn-primary"><i class="fa fa-card"></i> Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $("#tableId").dataTable();
    </script>
@endpush
