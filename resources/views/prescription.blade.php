<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <link href="{{asset('css/css/bootstrap.css')}}" rel="stylesheet">
  <link href="{{asset('css/css/style.css')}}" rel="stylesheet">
  <!-- Responsive -->
  <link href="{{asset('css/css/responsive.css')}}" rel="stylesheet">
</head>
<style>
body{
  padding: 60px 10px 10px 30px;
  box-sizing: content-box;
}
@font-face {
  font-family: SolaimanLipi;
  font-style: normal;
  font-weight: 400;
  src: url({{asset('fonts/SolaimanLipi.ttf')}});
}

</style>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <span style="font-size:2.5em;">{{$info->dname}}</span>
        <br />
        <span style="font-size:1.2em;">
          {{$info->education}}<br />
          {{$info->spc}}<br />
          <strong style="color: green;">{{$info->work}}</strong>
        </span>
      </div>
      <div class="col-md-4" style="text-align: center;">
        <span style="font-size:2.5em;">Chamber</span>
        <br />
        <span style="font-size:1.2em;">
          {{$info->education}}<br />
          {{$info->spc}}<br />
          <strong style="color: green;">{{$info->work}}</strong>
        </span>
      </div>
      <div class="col-md-4" style="text-align: right;">
        <span style="font-size:2.5em;">{{$info->dname}}</span>
        <br />
        <span style="font-size:1.2em;">
          {{$info->education}}<br />
          {{$info->spc}}<br />
          <strong style="color: green;">{{$info->work}}</strong>
        </span>
      </div>
    </div>

    <div class="row" style="padding:5px; border-top:1px solid black;border-bottom:1px solid black;">
      <div class="col-sm-5" style="border-right:1px solid black;">Name : {{$info->name}}</div>
      <div class="col-sm-2" style="border-right:1px solid black;">Age : {{$info->age}}</div>
      <div class="col-sm-2" style="border-right:1px solid black;">Sex : {{$info->gender == 0?'Male':'Female'}}</div>
      <div class="col-sm-3">Date : {{date('d M Y', strtotime($info->meet_date))}}</div>
    </div>

    <div class="row">
      <!-- Left Side -->
      <div class="col-sm-3" style="font-size:1.2em;padding-top:5px;">
        <br />
        <p>BP <b style="margin-left: 20px;">:</b> {{$info->blood_presure}}</p>
        <p>BS<b style="margin-left: 20px;">:</b> {{$info->blood_sugar}}</p>
        <p>Pulse<b style="margin-left: 20px;">:</b>{{$info->pulse}}</p><br>
        <div class="row mb-2">
          <div class="col-sm-12 col-md-12">
              {{$info->symptom}}
          </div>
        </div><br>
        <div class="row mb-2">
          <div class="col-sm-12 col-md-12">
            {{$info->test}}
          </div>
        </div>
      </div>
      <!-- Right Side -->
      <div class="col-sm-9" style="min-height:400px;font-size:1.2em;padding-top:5px;border-left:1px solid black;">
        <?php
        $sl = 1;
        ?>
        @foreach($qMedicine as $sMedicine)

        <!--  -->
        @endforeach
      </div>
    </div>
    <!-- Prescription Footer -->

    <div class="row text-center font" style="border-top:1px solid black;padding:5px; font-weight: bold;">
      <b> ????????? ???????????? </b>  ??????-?????????, ????????????-????????????, ????????? ??? ???????????? ??????????????? ??????????????? ??????????????????
    </div>
    <div class="row text-center" style="border-top:1px solid black;padding:5px;">
      This is computer generated Prescription.Generated by <a href="http://devmizanur.com" style="color:red; font-weight: bolder;">Mizanur Rahman</a>
    </div>
  </div>
</body>
</html>