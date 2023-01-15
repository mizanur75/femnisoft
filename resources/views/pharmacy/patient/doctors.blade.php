@extends('layouts.app')
@section('title','Choose Your Doctor')

@push('css')
<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap4.min.css')}}">
@endpush


@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<div class="table-responsive mb-3">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#SL</th>
							<th>Image</th>
							<th>Name</th>
							<th>Title</th>
							<th>Specialist</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
					@foreach($doctors as $doctor)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td><img src="{{asset('images/doctor/'.$doctor->image)}}" style="width: 100px; height: auto; border-radius: 50%;" alt="{{$doctor->name}}"></td>
							<td>{{$doctor->name}}</td>
							<td>{{$doctor->title}}</td>
							<td>{{$doctor->specialist}}</td>
							<td class="text-center">
							<a href="{{ route('agent.sendrequest',['doctor_id'=>$doctor->id, 'patient_id'=>$patient->id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Send Request</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
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