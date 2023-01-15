@extends('layouts.app')

@section('title','Pharmacy Dashboard')

@push('css')
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{Session::get('success')}}</strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        @if(Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{Session::get('danger')}}</strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
    </div>
    @php
        $totalamount = 0;
        $givenamount = 0;
        $tcosts = 0;
        $buyamount = 0;
    @endphp
    @foreach ($invoices as $invoice)
        @php
        $totalamount += $invoice->total_amount;
        $givenamount += $invoice->given_amount;
        @endphp
    @endforeach
    @foreach ($reports as $report)
        @php
            $buyamount += $report->tp * $report->qty;
        @endphp
    @endforeach
    @foreach ($costs as $cost)
        @php
            $tcosts += $cost->cost_price;
        @endphp
    @endforeach
    @php($nit_profit = $totalamount -  $tcosts)
        <!-- Widget Item -->
    <div class="col-md-2">
        <div class="widget-area proclinic-box-shadow color-blue">
            <div class="widget-left">
                <i class="fas fa-capsules"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Medicine(s)</h4>
                <span class="numeric">{{$products->count()}}</span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <div class="col-md-2">
        <div class="widget-area proclinic-box-shadow color-yellow">
            <div class="widget-left">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Sales Invoice</h4>
                <span class="numeric color-yellow">{{$invoices->count()}}</span>
            </div>
        </div>
    </div>
    <!-- Widget Item -->
    <div class="col-md-2">
        <div class="widget-area proclinic-box-shadow color-blue">
            <div class="widget-left">
                <span class="fas fa-money"></span>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Sales Amount</h4>
                <span class="numeric color-blue">{{number_format($totalamount)}}</span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <div class="col-md-2">
        <div class="widget-area proclinic-box-shadow color-red">
            <div class="widget-left">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Cost Amount</h4>
                <span class="numeric color-red">{{number_format($tcosts)}}</span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <!-- /Widget Item -->
    <div class="col-md-2">
        <div class="widget-area proclinic-box-shadow color-red">
            <div class="widget-left">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Due Amount</h4>
                <span class="numeric color-red">{{$totalamount - $givenamount}}</span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
    <div class="col-md-2">
        <div class="widget-area proclinic-box-shadow color-green">
            <div class="widget-left">
                <i class="fas fa-money"></i>
            </div>
            <div class="widget-right">
                <h4 class="wiget-title">Total Profit</h4>
                <span class="numeric color-green">{{number_format($nit_profit)}}</span>
            </div>
        </div>
    </div>
    <!-- /Widget Item -->
</div>
@php( $year = date('Y', strtotime(now())))
@php( $month = date('m', strtotime(now())))
<div class="row">
    <!-- Widget Item -->
    <div class="col-md-12">
        <div class="widget-area-2 proclinic-box-shadow">
            <h3 class="widget-title">Graph Report by Month - {{$year}}</h3>
            <div style="width: 100%;">
                <canvas id="canvas" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('js/Chart.js')}}"></script>
<script src="{{asset('js/utils.js')}}"></script>
<script>
        var month = '{{$month}}';

        var jacost = '{{$jacost}}';
        var fcost = '{{$fcost}}';
        var mcost = '{{$mcost}}';
        var apcost = '{{$apcost}}';
        var macost = '{{$macost}}';
        var jcost = '{{$jcost}}';
        var jucost = '{{$jucost}}';
        var aucost = '{{$aucost}}';
        var secost = '{{$secost}}';
        var occost = '{{$occost}}';
        var nocost = '{{$nocost}}';
        var dcost = '{{$dcost}}';

        var jasales = '{{$jasales}}';
        var fsales = '{{$fsales}}';
        var msales = '{{$msales}}';
        var apsales = '{{$apsales}}';
        var masales = '{{$masales}}';
        var jsales = '{{$jsales}}';
        var jusales = '{{$jusales}}';
        var ausales = '{{$ausales}}';
        var sesales = '{{$sesales}}';
        var ocsales = '{{$ocsales}}';
        var nosales = '{{$nosales}}';
        var dsales = '{{$dsales}}';

        var janprofit = '{{$jasales -  $jacost}}';
        var fnprofit = '{{$fsales - $fcost}}';
        var mnprofit = '{{$msales - $mcost}}';
        var apnprofit = '{{$apsales -  $apcost}}';
        var manprofit = '{{$masales -  $macost}}';
        var jnprofit = '{{$jsales - $jcost}}';
        var junprofit = '{{$jusales -  $jucost}}';
        var aunprofit = '{{$ausales -  $aucost}}';
        var senprofit = '{{$sesales -  $secost}}';
        var ocnprofit = '{{$ocsales -  $occost}}';
        var nonprofit = '{{$nosales -  $nocost}}';
        var dnprofit = '{{$dsales - $dcost}}';


        var japrofit = '{{$jasales -  $jatp}}';
        var fprofit = '{{$fsales - $ftp}}';
        var mprofit = '{{$msales - $mtp}}';
        var approfit = '{{$apsales -  $aptp}}';
        var maprofit = '{{$masales -  $matp}}';
        var jprofit = '{{$jsales - $jtp}}';
        var juprofit = '{{$jusales -  $jutp}}';
        var auprofit = '{{$ausales -  $autp}}';
        var seprofit = '{{$sesales -  $setp}}';
        var ocprofit = '{{$ocsales -  $octp}}';
        var noprofit = '{{$nosales -  $notp}}';
        var dprofit = '{{$dsales - $dtp}}';

        var year = '{{$year}}';

        var color = Chart.helpers.color;
        var barChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'Sales',
                    backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.blue,
                    borderWidth: 1,
                    data: [
                        (month > 0)? jasales : null, (month > 1)? fsales :null, (month > 2)? msales :null , (month > 3)? apsales : null, (month > 4)? msales :null, (month > 5)? jsales :null, (month > 6)? jusales:null, (month > 7)? ausales :null, (month > 8)? sesales: null, (month > 9)? ocsales :null, (month > 10)? nosales : null, (month > 11)? dsales : null,
                    ]
                }, 
                {
                    label: 'Cost',
                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    data: [
                        (month > 0)? jacost : null, (month > 1)? fcost :null, (month > 2)? mcost :null , (month > 3)? apcost : null, (month > 4)? macost :null, (month > 5)? jcost :null, (month > 6)? jucost:null, (month > 7)? aucost :null, (month > 8)? secost: null, (month > 9)? occost :null, (month > 10)? nocost : null, (month > 11)? dcost : null,
                    ]
                }, 
                {
                    label: 'Gros Profit',
                    backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.yellow,
                    borderWidth: 1,
                    data: [
                        (month > 0)? japrofit : null, (month > 1)? fprofit :null, (month > 2)? mprofit:null , (month > 3)? approfit : null, (month > 4)? mprofit :null, (month > 5)? jprofit :null, (month > 6)? juprofit:null, (month > 7)? auprofit :null, (month > 8)? seprofit: null, (month > 9)? ocprofit :null, (month > 10)? noprofit : null, (month > 11)? dprofit : null,
                    ]
                },
                {
                    label: 'Nit Profit',
                    backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.green,
                    borderWidth: 1,
                    data: [
                        (month > 0)? janprofit : null, (month > 1)? fnprofit :null, (month > 2)? mnprofit:null , (month > 3)? apnprofit : null, (month > 4)? mnprofit :null, (month > 5)? jnprofit :null, (month > 6)? junprofit:null, (month > 7)? aunprofit :null, (month > 8)? senprofit: null, (month > 9)? ocnprofit :null, (month > 10)? nonprofit : null, (month > 11)? dnprofit : null,
                    ]
                }
            ]

        };

        window.onload = function() {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                }
            });

        };

    </script>
@endpush