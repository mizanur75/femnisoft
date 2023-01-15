@extends('layouts.app')
@section('title','Export OPD Data')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}"> -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>

        select.form-control:not([size]):not([multiple]) {
            height: 1.8rem;
            width: 3rem;
        }
        .search-box{
            padding: 1px 10px !important;
        }

        @media (max-width: 768px){
            .search-box{
                padding: 1px 15px !important;
            }
        }
    </style>
@endpush


@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            @if(Session::has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('danger') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow search-box">
                <form action="{{route('doctor.export_excel')}}" method="GET">
                    <div class="row">
                        @csrf
                        <div class="col-md-4">
                            <input type="text" name="start" id="start" style="height: 30px;" class="form-control form-control-sm" placeholder="Start Date" @if($start) value="@if($start){{date('d-m-Y', strtotime($start))}}@endif" @endif autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="finish" id="finish" style="height: 30px;" class="form-control form-control-sm" placeholder="End Date" @if($finish) value="{{date('d-m-Y', strtotime($finish))}}" @endif autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" style="height: 100%;" class="btn btn-sm btn-block btn-info btn-padding"><i class="fa fa-export"></i> Export to Excel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="widget-area-2 proclinic-box-shadow">
                <div class="float-right">
                    <form action="{{route('doctor.export_search')}}" method="GET">
                        <input type="text" class="form-control form-control-sm float-right" style="height: 29px;" name="ecohid" placeholder="Input ECOH ID Press Enter" autocomplete="on">
                    </form>
                </div>
                <h3 class="widget-title">OPD Data</h3>
                <div class="table-responsive">
                    <table id="_infotable" class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>#SL</th>
                            <th>Date</th>
                            <th>Visit</th>
                            <th>ECOH ID</th>
                            <th>Pt. Type</th>
                            <th>Patient's Name</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Edu.</th>
                            <th>Address</th>
                            <th>Doctor's Name</th>
                            <th width="15%">Pri. Dx</th>
                            <th width="15%">Sec. Dx1</th>
                            <th width="15%">Sec. Dx2</th>
                            <th>SBP</th>
                            <th>DBP</th>
                            <th>Pulse</th>
                            <th>Oxy</th>
                            <th>Temp</th>
                            <th>Ht</th>
                            <th>Wt</th>
                            <th>BMI</th>
                            <th>Edema</th>
                            <th>Anemia</th>
                            <th>Heart</th>
                            <th>Lungs</th>
                            <th>Jaundice</th>
                            <th>HTN</th>
                            <th>DM</th>
                            <th>IHD</th>
                            <th>STRK</th>
                            <th>COPD</th>
                            <th>Cancer</th>
                            <th>CKD</th>
                            <th>Salt</th>
                            <th>SLT</th>
                            <th>Smoking</th>
                            <th>WBC</th>
                            <th>%LYM</th>
                            <th>GRA%</th>
                            <th>RBC</th>
                            <th>HGB</th>
                            <th>HCT</th>
                            <th>MCV</th>
                            <th>MCH</th>
                            <th>MCHC</th>
                            <th>PLT</th>
                            <th>ESR</th>
                            <th>%Neu</th>
                            <th>Bl. Gr.</th>
                            <th>Chol</th>
                            <th>Tg</th>
                            <th>Gluc-f</th>
                            <th>Gluc-r</th>
                            <th>Gluc-2hr</th>
                            <th>Creat</th>
                            <th>UA</th>
                            <th>CRP</th>
                            <th>RA</th>
                            <th>Ugl</th>
                            <th>Upr</th>
                            <th>Uery</th>
                            <th>Uleu</th>
                            <th>ECG</th>
                            <th>USG</th>
                            <th>CXR</th>
                            <!-- <th>Con-fee</th>
                            <th>Lab-fee</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($patient_data as $data)
                            <tr class="text-center">
                                <td>{{$loop->index +1}}</td>
                                <td>{{date('d-m-Y', strtotime($data->visit_date))}}</td>
                                <td>{{$data->visit}}</td>
                                <td>{{$data->ecohid}}</td>
                                <td>{{$data->mem_type == null ? ($data->reg_mem == null ? 'OPD' : $data->reg_mem) : $data->mem_type}}</td>
                                <td>{{$data->patient_name}}</td>
                                <td>
                                    <?php
                                        $birth_date = new \DateTime($data->dob);
                                        $meet_date = new \DateTime($data->visit_date);
                                        $interval = $birth_date->diff($meet_date);
                                        $age = $interval->format('%y');
                                    ?>
                                        {{$age}}
                                </td>
                                <td>{{$data->sex == 0 ? 'Male' : 'Female'}}</td>
                                <td>{{$data->edu}}</td>
                                <td>{{$data->address}}</td>
                                <td>{{$data->dname}}</td>
                                <td width="15%">{{$data->diagnosis}}</td>
                                <td width="15%">{{$data->sec_diagnosis}}</td>
                                <td width="15%">{{$data->sec_dx2}}</td>
                                <td>{{$data->blood_presure == 'N/A' ? '' : $data->blood_presure}}</td>
                                <td>{{$data->dbp}}</td>
                                <td>{{$data->pulse}}</td>
                                <td>{{$data->oxygen}}</td>
                                <td>{{$data->temp}}</td>
                                <td>{{$data->height}}</td>
                                <td>{{$data->weight}}</td>
                                <td>
                                    @if($age >= 15)
                                    {{$data->bmi}}
                                    @endif
                                </td>
                                <td>{{$data->edima}}</td>
                                <td>{{$data->anemia}}</td>
                                <td>{{$data->heart}}</td>
                                <td>{{$data->lungs}}</td>
                                <td>{{$data->jaundice}}</td>
                                <td>{{$data->hp}}</td>
                                <td>{{$data->diabeties}}</td>
                                <td>{{$data->ihd}}</td>
                                <td>{{$data->strk}}</td>
                                <td>{{$data->copd}}</td>
                                <td>{{$data->cancer}}</td>
                                <td>{{$data->ckd}}</td>
                                <td>{{$data->salt}}</td>
                                <td>{{$data->smoke}}</td>
                                <td>{{$data->smoking}}</td>
                                <td>{{$data->wbc}}</td>
                                <td>{{$data->lym}}</td>
                                <td>{{$data->gra}}</td>
                                <td>{{$data->rbc}}</td>
                                <td>{{$data->hb}}</td>
                                <td>{{$data->hct}}</td>
                                <td>{{$data->mcv}}</td>
                                <td>{{$data->mch}}</td>
                                <td>{{$data->mchc}}</td>
                                <td>{{$data->plt}}</td>
                                <td>{{$data->esr}}</td>
                                <td>{{$data->neu}}</td>
                                <td>{{$data->blood_group}}</td>
                                <td>{{$data->chol}}</td>
                                <td>{{$data->tg}}</td>
                                <td>{{$data->glucf}}</td>
                                <td>{{$data->glucr}}</td>
                                <td>{{$data->gluc2hr}}</td>
                                <td>{{$data->creat}}</td>
                                <td>{{$data->ua}}</td>
                                <td>{{$data->crp}}</td>
                                <td>{{$data->ra}}</td>
                                <td>{{$data->ugl}}</td>
                                <td>{{$data->upr}}</td>
                                <td>{{$data->uery}}</td>
                                <td>{{$data->uleu}}</td>
                                <td>{{$data->ecg}}</td>
                                <td>{{$data->usg}}</td>
                                <td>{{$data->cxr}}</td>
                                <!-- <td>{{$data->app_fee}}</td>
                                <td>{{$data->lab_fee}}</td>
 -->                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$patient_data->links()}}
                </div>
            </div>
        </div>
        <!-- /Widget Item -->
    </div>

@endsection

@push('scripts')
    <script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('datetime_picker/jquery-ui.js')}}"></script>
    <script>
        $("#infotable").dataTable({
            pageLength : 50,
            lengthMenu: [[50, 10, 20, 100, 500], [50, 10, 20, 100, 500]]
        });
        $(function() {
            $( "#start" ).datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });

        $(function() {
            $( "#finish" ).datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
@endpush
