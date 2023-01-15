@extends('layouts.app')
@section('title','Prescription of '.$info->name)

@push('css')
<style>
table tr td{
  border: none !important;
}
div[class*="col-"] {
    padding-right: 10px;
    padding-left: 11px;
}
p {
    font-size: 1em;
    line-height: 1.2em;
    color: #666;
    letter-spacing: .3px;
    margin-top: 0;
    margin-bottom: 0.8rem;
}
hr {
    margin-top: 3px; 
    margin-bottom: 3px; 
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}
.doctor{
  font-size: large;
}

@media (min-width: 769px){
  div[class*="col-print"] {
      padding-right: 5px;
      padding-left: 5px;
  }
}
@media (max-width: 768px){
  .pl-2{
      padding-right: 0px;
      
  }
  .pr-2{
    padding-left: 0px;
  }
}
</style>
@endpush


@section('content')
<div class="row">
  <div class="col-md-12 col-print">
    <div class="widget-area-2 text-right pt-2">
      <!-- <button type="button" class="btn btn-padding btn-sm btn-success"><i class="fa fa-shopping-cart"></i> Order Medicine</button> -->
      <button type="button" id="print" class="btn btn-padding btn-sm btn-success"><i class="fa fa-print"></i> Print</button>
    </div>
  </div>
</div>

<div class="row pres-row">
  <div class="col-sm-12 col-md-12 bg-white mt-3 pres col-pres" id="printarea">
    <div class="row mb-1">
      <div class="col-md-4">
        <h4 class="color-green font-weight-bold" style="margin-top: 18px; margin-bottom: -10px;">এখলাসপুর সেন্টার অফ হেলথ</h4><br>
        <span><strong>এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১</strong></span>
      </div>
      <div class="col-md-4 text-center">
      <img src="{{asset('assets/images/logo-dark.png')}}" class="logo" alt="logo">
      </div>
      <div class="col-md-4 col-sm-12 text-right">
        <h4 class="color-green font-weight-bold" style="margin-top: 18px; margin-bottom: -10px;">Ekhlaspur Center of Health</h4><br>
        <span class="font-weight-bold">Ekhlaspur, Matlab North, Chandpur 3641</span>
      </div>
    </div>

    <div class="row patient-info">
      <div class="col-sm-4 pt-0 pb-0 patient"><b>Name:</b> {{$info->name}}</div>
      <div class="col-sm-2 pt-0 pb-0 patient"><b>ECOH ID:</b> {{$info->centerid}}</div>
      <div class="col-sm-1 pt-0 pb-0 patient"><b>Age:</b> {{$info->age}}</div>
      <div class="col-sm-2 pt-0 pb-0 patient"><b>Sex:</b> {{$info->gender == 0?'Male':'Female'}}</div>
      <div class="col-sm-2 pt-0 pb-0"><b>Date:</b> {{date('d M Y', strtotime($info->meet_date))}}</div>
    </div>
    <div class="row">
      <div class="col-sm-3 patient">
        <b>O/E</b>:
        <hr>
        <p>BP <b style="margin-left: 39px;">:</b> {{$info->bp}}mm of Hg</p>
        <p>Pulse<b style="margin-left: 24px;">:</b> {{$info->pulse}}/min</p>
        <p>Temp.<b style="margin-left: 18px;">:</b> {{$info->temp}}°F</p>
        <p>Weight<b style="margin-left: 13px;">:</b> {{$info->weight}}kg</p>
        <p>Height<b style="margin-left: 16px;">:</b> {{$info->height}}cm</p>
        <p>O<sub>2</sub> Satu.<b style="margin-left: 5px;">:</b> {{$info->oxygen}}%</p>
        @if($info->predochos || $info->pretreatment)
        <b>Prevoius History:</b>
        <hr>
        <p>Dr/Hos. Name: {{$info->predochos}}</p>
        <p>Invest: @php($preinvs = \App\Model\Inv::where('info_id',$info->piid)->get())
                @foreach($preinvs as $preinv)
                {{$preinv->test_name}} - {{$preinv->result}};
                @endforeach
        </p>
        <p>Treat: {{$info->pretreatment}}</p>
        @endif
        <div class="row mb-2 mr-2">
          <div class="col-sm-12 col-md-12">
            <strong>C/C:</strong> <hr>{{$info->cc}}
          </div>
        </div>
        <div class="row mb-2 mr-2">
          <div class="col-sm-12 col-md-12">
            <strong>Investigation Find:</strong><hr> 
            @if($info->test == !null)
              @php($givenTest = explode(', ',$info->test))
              @foreach($givenTest as $gTest)
                @php($getTest = \App\Model\Test::where('test_name',$gTest)->first())
                @if($getTest)
                    @php($getResult = \App\Model\Report::where('test_id',$getTest->id)->where('history_id',$info->hid)->first())
                    @if($getResult)
                      {{$gTest}}: {{$getResult->result}} {{$getResult->remark == null ? '':'- '.$getResult->remark}}<br>
                    @else
                      {{$gTest}}: <span class="text-danger">Not Added Yet</span> <br>
                    @endif
                  @endif
              @endforeach
            @else
            No Investigation Find
            @endif
          </div>
        </div>
        <div class="row mb-2 mr-2">
          <div class="col-sm-12 col-md-12">
            <strong>Diagnosis:</strong><hr> {{$info->diagnosis}}
          </div>
        </div>
        @if($info->suggested_test)
        <div class="row mb-2 mr-2">
          <div class="col-sm-12 col-md-12">
            <strong>Suggested Test:</strong>
            <hr>
            {{$info->suggested_test}}
          </div>
        </div>
        @endif
      </div>

      <div class="col-sm-8 ml-3" style="min-height:400px; font-size:1em; margin-top:20px;">
        <h3>R<span style="font-size:12px;">x</span></h3>
        <div>
          <table class="table table-sm">
            @foreach($prescriptions as $prescription)
            <tr>
              <td></td>
              <td>
                <span class="doctor"> 
                  {{$loop->index + 1}}. 
                  @php($cat = substr($prescription->cat, 0, 3))
                  @if($cat == 'Syr')
                  Syp.
                  @else
                  {{$cat}}.
                  @endif
                </span>
              </td>
              <td><span class="doctor"> {{$prescription->medname}} - {{$prescription->mes}}</span></td>
              <td></td>
              <td><span class="doctor"> {{$prescription->dose_duration == '0' ? '':$prescription->dose_duration}} {{$prescription->dose_duration_type}}</span></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td><span class="doctor"> {{$prescription->dose_time}}</span></td>
              <td><span class="doctor"> 
                @if($prescription->dose_qty == '১/২')
                <sup>১</sup>&frasl;<sub>২</sub>
                @elseif($prescription->dose_qty == '৩/৪')
                <sup>৩</sup>&frasl;<sub>৪</sub>
                @elseif($prescription->dose_qty == '১.১/২')
                ১<sup>১</sup>&frasl;<sub>২</sub>
                @elseif($prescription->dose_qty == '২.১/২')
                ২<sup>১</sup>&frasl;<sub>২</sub>
                @else
                {{$prescription->dose_qty}}
                @endif
                {{$prescription->dose_qty_type}} করে {{$prescription->dose_eat}}</span></td>
              <td></td>
            </tr>
            @endforeach
          </table>
        </div>
        <br>
        <br>
        <div class="row mt-2 mb-2">
          <div class="col-sm-9 col-md-8">
            <h6 class="font-weight-bold">উপদেশঃ-</h6>
            @if($info->advices)
              @php($advices = explode('।, ',$info->advices))
              <ul>
              @foreach($advices as $advice)
              <li>{{$advice}} {{$loop->index +1 == count($advices) ? '':'।'}}</li>
              @endforeach
            @endif
            </ul>

          </div>
          <div class="col-sm-3 col-md-4">
            <h6>Electronic Signature</h6>
            <img src="{{asset('images/signature/'.$info->signature)}}" style="height: 70px;">
            <h5 class="font-weight-bold" style="margin-bottom: 0px;">{{$info->dname}}</h5>
            <span>{{$info->education}}</span><br>
            <span>{{$info->spc}}</span><br>
            <span>BM&DC Reg. No: {{$info->regi_no}}</span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row text-center" style="border-top:1px solid #2b6749; padding:5px; text-align: center !important;">
      <div class="col-sm-12 col-print text-center"> <span class="font-weight-bold"> {{$info->next_meet}} </span> পর আসবেন। পরবর্তী ভিজিটের সময় অবশ্যই ব্যবস্থাপত্র সাথে আনবেন। ধন্যবাদ।
      </div>
    </div>
    <div class="row" style="border-top:1px solid #2b6749;padding:5px;">
      <div class="col-sm-12 col-print text-center" style="padding: 0px 0px 10px 0px;">
        Mobile: 01766020707 | Email: chandpurecoh3641@gmail.com | Website: www.ecohbd.org <br> Developed & Maintenance by <a href="https://devmizanur.com" target="_blank"> www.devmizanur.com</a>
      </div>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
$(function(){
  $("#print").click(function(){
    $("#printarea").show();
    window.print();
  });
});
</script>
@endpush