@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('customer.new_customer')}}</div>
				<div class="panel-body">
					{!! Html::ul($errors->all()) !!}

					{!! Form::open(array('url' => 'customers', 'files' => true)) !!}

					<div class="form-group">
					{!! Form::label('name', trans('customer.name')  ) !!}
					{!! Form::text('name', Input::old('name'), array('class' => 'form-control','required'=>'required')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('email', trans('customer.email')) !!}
					{!! Form::email('email', Input::old('email'), array('class' => 'form-control','required'=>'required')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('phone_number', trans('customer.phone_number') ) !!}
					{!! Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control','required'=>'required')) !!}
					</div>

					 
					<div class="form-group">
					{!! Form::label('address', trans('customer.address')) !!}
					{!! Form::text('address', Input::old('address'), array('class' => 'form-control','required'=>'required')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('city', trans('customer.city')) !!}
					{!! Form::text('city', Input::old('city'), array('class' => 'form-control','required'=>'required')) !!}
					</div>

					 

					 <div class="form-group">
					<label for="address">Region</label>
					 <select class="form-control" name="state" required="">
					 	<option value="">Select Region</option>
					 	<option value="Greater Accra">Greater Accra Region</option>
					 	<option value="Ashanti">Ashanti Region</option>
					 	<option value="Western">Western Region</option>
					 	<option value="Volta">Volta Region</option>
					 	<option value="Brong Ahafo">Brong Ahafo Region</option>
					 	<option value="Central">Central Region</option>
					 	<option value="Upper West">Upper West Region</option>
					 	<option value="Upper East">Upper East Region </option>
					 	<option value="Northen">Northen Region</option>
					 </select>
					</div>
 

					 
					{!! Form::submit(trans('customer.submit'), array('class' => 'btn btn-primary')) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection