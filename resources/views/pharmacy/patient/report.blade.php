@extends('layouts.app')
@section('title','Report of '.$info->name)

@push('css')

@endpush


@section('content')
<div class="row">
	<!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Patient Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong>Name</strong></td>
							<td>{{$info->name}}</td>
						</tr>
						<tr>
							<td><strong>Age</strong> </td>
							<td>{{$info->age}}</td>
						</tr>
						<tr>
							<td><strong>Gender</strong></td>
							<td>
								{{$info->gender == 0 ? 'Male':'Female'}}
							</td>
						</tr>
						<tr>
							<td><strong>Address</strong></td>
							<td>{{$info->address}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->
    <!-- Widget Item -->
	<div class="col-md-6">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Suggested by</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td><strong>Doctor Name</strong></td>
							<td>{{$info->dname}}</td>
						</tr>
						<tr>
							<td><strong>Title</strong> </td>
							<td>{{$info->title}}</td>
						</tr>
						<tr>
							<td><strong>Spcialist</strong></td>
							<td>
								{{$info->spcialist}}
							</td>
						</tr>
						<tr>
							<td><strong>Work Station </strong></td>
							<td>{{$info->work}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <!-- /Widget Item -->

	<div class="col-md-12">
		<div class="widget-area-2 proclinic-box-shadow">
			<h3 class="widget-title">Reports of {{$info->name}} </h3>
			<div class="table-responsive">
				<table id="tableId" class="table table-bordered table-striped table-sm">
					<thead>
						<tr class="text-center">
							<th>#SL</th>
							<th>Test Name</th>
							<th>Default Value</th>
							<th>Result</th>
							<th>Remark</th>
							<th>Image</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($reports as $report)
							<tr class="text-center">
								<td>{{$loop->index +1}}</td>
								<td>{{$report->test}}</td>
								<td>{{$report->dvalue}}</td>
								<td>{{$report->result}}</td>
								<td>{{$report->remark}}</td>
								<td>
									@if(!empty($report->image))
									<a target="_blank" href="{{asset('images/report/'.$report->image)}}"><img src="{{asset('images/report/'.$report->image)}}" height="100" width="100"></a>
									@else
									<button type="button" class="btn btn-sm btn-danger">No Image Available</button>
									@endif
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
@endsection


@push('scripts')


@endpush
