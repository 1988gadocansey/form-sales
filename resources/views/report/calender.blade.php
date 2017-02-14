@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             <a style='float: right' onclick="javascript:printDiv('print')" class="btn btn-success">Click to print report</a>
               
            <div class="panel panel-default">
                <div class="panel-heading">Sales Report</div>
                {!! Form::open(array('url' => '/reports/detail', 'files' => true)) !!}

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="start" placeholder="select start date "class="form-control datepicker">
   
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="end" placeholder="select end date" class="form-control datepicker">
   
                        </div>
                         <div class="col-md-4">
                          <select placeholder='select user'   style="" name="user"  class='form-control'v-model='user' v-form-ctrl='' v-select=''>
                              <option value="">Select user</option>
                                                    @foreach($user as $item=>$rows)

                                                    <option 
                                                                            
                                                                           value='{{$rows->id}}'>{{$rows->name}} </option>
                                                 @endforeach
                                                    </select> 
                        </div>
                       
                    </div>
                    <p>&nbsp;</p>
                     <div class="col-md-4" style="margin-left: 390px">
                          {!! Form::submit(trans('customer.submit'), array('class' => 'btn btn-primary')) !!}

					
                            </div> 
                </div>
           	{!! Form::close() !!}
              @if(Request::isMethod('post'))
                <div id='print'>
                    
                     <center><span class="text-success text-bold" style="color:red;font-weight: bold">Total Form Sold at {{$seller}}  {!! $data->total()!!} Records between {{$start}} and {{$end}}</span></center>
                    
                    <hr>
                                                  
  <table class="table table-striped table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Applicant</th>
                                <th>Form Purchased</th>
                                
                                <th>Amount</th>
                            </tr>
                        </thead> <?php $total=array();?>
                         @foreach(@$data as $item=>$rows)
                        
                         <tr>
                        <td> {{ $data->perPage()*($data->currentPage()-1)+($item+1) }} </td>
                         <td>{{@$rows->name}}</td>
                          <td>{{@$rows->item_name}}</td>
                         <?php $total[]=@$rows->selling_price  ?>
                         <td>GHC{{@$rows->selling_price}}</td>
                         
                         </tr>
                         @endforeach
                    </table>
                     <hr>
                     
                     <p style="margin-left: 441px;color:red" class="text-success text-bold">TOTAL SALES GHC{{array_sum($total)}}.00</p>
                     <u></u>
                </div>
              @endif
            </div>
        </div>
    </div>
</div>

@endsection