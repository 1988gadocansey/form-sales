@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('customer.list_customers')}}</div>

				<div class="panel-body">
				<a class="btn btn-small btn-success" href="{{ URL::to('customers/create') }}">{{trans('customer.new_customer')}}</a>
				<hr />
@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>{{trans('customer.customer_id')}}</td>
            <td>{{trans('customer.name')}}</td>
            <td>{{trans('customer.email')}}</td>
            <td>{{trans('customer.phone_number')}}</td>
            @if(Auth::user()->role==1)
            <td>Added by</td>
           @endif
        </tr>
    </thead>
    <tbody>
    @foreach($customer as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->phone_number }}</td>
             @if(Auth::user()->role==1)
            <td>{{ $value->owner }}</td>
               @endif
               
        </tr>
    @endforeach
    </tbody>
</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection