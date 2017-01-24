@extends('app')
@section('content')
{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/app.js', array('type' => 'text/javascript')) !!}
<style>
table td {
    border-top: none !important;
}
</style>
<div class="container-fluid">
   <div class="row">
        <div class="col-md-12" style="text-align:center">
        <p><img  class="image-responsive"alt="logo" style="width:59px;height:63px" src="{{url('images/logo.png')}}" alt='logo'/></p>
           <p> Takoradi Technical University</p>
           <p>Admissions Forms Point of Sale</p>
           <p><strong>PIN CODE: <span  style='color: purple'>{{$pin}} </span></strong>     <strong>  SERIAL NO: <span style='color:green'>{{$serial}}</span></strong></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{trans('sale.customer')}}: {{ $sales->customer->name}}<br />
            {{trans('sale.sale_id')}}: SALE{{$saleItemsData->sale_id}}<br />
            {{trans('sale.employee')}}: {{$sales->user->name}}<br />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
           <table class="table table-striped">
                <tr>
                    <td>{{trans('sale.item')}}</td>
                    <td>{{trans('sale.price')}}</td>
                    <td>{{trans('sale.qty')}}</td>
                    <td>{{trans('sale.total')}}</td>
                </tr>
                @foreach($saleItems as $value)
                <tr>
                    <td>{{$value->item->item_name}}</td>
                    <td>{{$value->selling_price}}</td>
                    <td>{{$value->quantity}}</td>
                    <td>{{$value->total_selling}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{trans('sale.payment_type')}}: {{$sales->payment_type}}
        </div>
    </div>
    <hr class="hidden-print"/>
    <div class="row">
        <div class="col-md-8">
            &nbsp;
             <p><center><strong>STEPS IN FILLING THE FORM</strong></center></p>
                                        <hr>
			<p>All Ghanaian applicants for the <?php echo (date("Y") ) ."/".(date("Y")+1);?> Academic year admission are required to use Takoradi Technical University online admission portal. The procedure for the online application process is as follows:</p>
			<p>
				<strong>I. </strong>You are kindly advised to use Mozilla Firefox or
				Chrome browser for the online admission form filling
			</p>
			<p>
				<strong>II.</strong>Goto admissions.ttu.edu.gh
			</p>
			<p>
				<strong>II. </strong>Login with serial number and pin code in the
				receipt you were given
			</p>
			<p>
				<strong>III. </strong>The Serial Number and Pin Code can be used for
				maximum of 10 times after which it will be deactivated
			</p>

			<p>
				<strong>IV. </strong>. In completing the online form, applicants will
				be required to upload their passport size photograph (not more than
				500KB) with a white background.
			</p>
			<p>
				<strong>V.  </strong>Applicants are advised to check thoroughly all
				details entered before they finally submit their online
				applications. A form, once submitted, can be viewed, but cannot be
				edited.
			</p>
			<p>
				<strong>VII.</strong> Applicants should print out application
				summary; attach result slips,certificates (WASSCE/SSSCE)or
				Certificates(BTECH) and all other relevant documents.
			</p>
			<p>
				<strong>VIII. </strong>The application documents as specified (III)
				above should sent by post to
			<p align="center"><strong>The Registrar</strong></p>
                                <p align="center"><strong>Takoradi Polytechnic,</strong></p>
                                <p align="center"><strong>P. O Box 256, Takoradi, W/R.</strong></p>
								<p align="left"><strong>For more information call 033 2094767 / 0262321123 / 0505284060</strong></p>
                                 
                                       
            
        </div>
        <div class="col-md-2">
            <button type="button" onclick="printInvoice()" class="btn btn-info pull-right hidden-print">{{trans('sale.print')}}</button> 
        </div>
        <div class="col-md-2">
            <a href="{{ url('/sales') }}" type="button" class="btn btn-info pull-right hidden-print">{{trans('sale.new_sale')}}</a>
        </div>
    </div>
</div>
<script>
function printInvoice() {
    window.print();
}
</script>
@endsection