@extends('layouts.app')
@section('title','My Client')

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
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
		@if(Session::has('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ Session::get('success') }}</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
		@endif
			<div class="table-responsive">
				<div class="row mb-2">
                    <div class="col-md-3">
                        <form action="{{route('doctor.mypatient')}}" method="GET">
                        <select class="form-control form-control-sm w-100" name="search_value" onchange="this.form.submit()" style="height:39px;">
                            <option value="20" {{$default_value == 20 ? 'selected' : ''}}>20</option>
                            <option value="50" {{$default_value == 50 ? 'selected' : ''}}>50</option>
                            <option value="100" {{$default_value == 100 ? 'selected' : ''}}>100</option>
                            <option value="500" {{$default_value == 500 ? 'selected' : ''}}>500</option>
                        </select>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <form action="{{route('doctor.patient_search')}}" method="GET">
                        <input type="text" name="patient_search" class="form-control form-control-sm" placeholder="Search (Input Client name, phone or Client ID and press enter)">
                        </form>
                    </div>
                </div>
				<table id="myTableId" class="table table-bordered table-striped">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<!-- <th>Sys. ID</th> -->
							<th>Client. ID</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Age</th>
							<th>Address</th>
							<th>B. Group</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
                        @if($patients)
                        @foreach($patients as $patient)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <!-- <td>Sys. ID</td> -->
                            <td class="text-center">{{$patient->centre_patient_id}}</td>
                            <td>{{$patient->name}}</td>
                            <td>{{$patient->phone}}</td>
                            <td class="text-center">
                                @php($dob = strlen($patient->age) < 5 ? now() : $patient->age)
                                @php($age = \Carbon\Carbon::parse($dob)->diff(\Carbon\Carbon::now())->format('%y'))
                                {{$age}}
                            </td>
                            <td class="text-center">{{$patient->address}}</td>
                            <td class="text-center">{{$patient->blood_group}}</td>
                            <!-- <td>Status</td> -->
                            <td class="text-center">
                                <a href="{{route('doctor.patient.show',$patient->id)}}" class="btn btn-padding btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>
                                <a href="{{route('doctor.patient.edit',$patient->id)}}" class="btn btn-padding btn-sm btn-primary"><i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        Sorry! No data found.
                        @endif
					</tbody>
				</table>
                @if($patients)
                    {{$patients->appends(Request::all())->links()}}
                @endif
			</div>
		</div>
	</div>
	<!-- /Widget Item -->
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script>
    // $(function (){
    //     $("#myTableId").dataTable({
    //         "order": [[ 0, "desc" ]],
    //         pageLength : 50,
    //         lengthMenu: [[50, 10, 20, 100, 500], [50, 10, 20, 100, 500]],
    //         serverSide: true,
    //         ajax: {
    //             url: "{{route('doctor.mypatient')}}",

    //             data: function (data) {
    //                 data.params = {
    //                     sac: "hello"
    //                 }
    //             }
    //         },
    //         buttons: true,
    //         processing: true,
    //         searching: true,
    //         columns: [
    //             // {data: 'DT_RowIndex', name: 'DT_Row_Index' },
    //             {data: "id", name: 'id', orderable: false},
    //             {data: "centre_patient_id", name: 'centre_patient_id'},
    //             {data: "name", name: 'name'},
    //             {data: "phone", name: 'phone'},
    //             {data: "age", name: 'age'},
    //             {data: "address", name: 'address'},
    //             {data: "blood_group", name: 'blood_group'},
    //             {data: "action", name: 'action', orderable: false}

    //         ],
    //         'columnDefs': [
    //             {"targets": 0, "className": "text-center"},
    //             {"targets": 1, "className": "text-center"},
    //             {"targets": 2, "className": "text-center"},
    //             {"targets": 3, "className": "text-center"},
    //             {"targets": 4, "className": "text-center"},
    //             {"targets": 5, "className": "text-center"},
    //             {"targets": 6, "className": "text-center"},
    //             {"targets": 7, "className": "text-center"},
    //         ],
    //     });
    // });
</script>
@endpush
