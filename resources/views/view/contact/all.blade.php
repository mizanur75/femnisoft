@extends('layouts.app')
@section('title','Contact')

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
@php($auth = Auth::user()->role->name)
<div class="row">
	<!-- Widget Item -->
	{{--<div class="col-md-12">--}}
        {{--<div class="widget-area-2 proclinic-box-shadow text-right pt-2">--}}
        	{{--<div class="row">--}}
        		{{--<div class="col-md-1 mt-2">--}}
		            {{--<a href="{{route('doctor.web-contact.create')}}" class="btn btn-padding btn-sm btn-success"><i class="fa fa-plus"></i> Add New</a>--}}
		        {{--</div>--}}
        	{{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
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

		@if($errors->any())
			@foreach($errors->all() as $error)
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Opps!</strong> {{$error}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			@endforeach
		@endif
		
        @if(Session::has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
			<div class="table-responsive">
				<table id="tableId" class="table table-sm table-bordered table-striped">
					<thead class="text-center">
						<tr>
							<th>#SL</th>
							<th>Name</th>
                            <th>Email</th>
                            <th>Message(s)</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($contacts)
						@foreach($contacts as $contact)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{$contact->name}}</td>
							<td>{{$contact->email}}</td>
							<td>{!! $contact->message !!}</td>
							<td class="text-center">
        						<form action="{{route('doctor.web-contact.destroy',$contact->id)}}" method="post" onsubmit="return confirm('Are you sure!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-padding btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
							</td>
						</tr>
						@endforeach
                        @else
                        Sorry! No data found.
                        @endif
					</tbody>
				</table>
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
    $("#tableId").dataTable();
</script>
@endpush
