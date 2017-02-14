<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sale;
use \Auth, \Redirect;
use Illuminate\Http\Request;

class ReportController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function report(Request $request)
	{
            $user=$request->input("user");
            $sellerQuery=@\DB::table('users')->where("id",$user)->first();
           $seller=$sellerQuery->name;
            $start=$request->input("start");
            $end=$request->input("end");
            $users=@\DB::table('users')->where("role","!=","6")->select("id","name")->get();
            if(empty($end)){
                $query=@\DB::table('sales')->join("sale_items","sales.id","=","sale_items.sale_id")->join("users","users.id","=","sales.user_id")->join("customers","customers.id","=","sales.customer_id")->join("items","items.id","=","sale_items.item_id")->where("sales.user_id",$user)
                        ->whereDate("sales.created_at","=",date("Y-m-d",strtotime($start)))
                        ->orderBy("sales.created_at","DESC")->paginate(17000);
            }
            else{
                 $query=@\DB::table('sales')->join("sale_items","sales.id","=","sale_items.sale_id")->join("users","users.id","=","sales.user_id")->join("customers","customers.id","=","sales.customer_id")->join("items","items.id","=","sale_items.item_id")->where("sales.user_id",$user)
                       
                         ->whereBetween("sales.created_at", array(date("Y-m-d",strtotime($start)), date("Y-m-d",strtotime($end))))
                        ->orderBy("sales.created_at","DESC")->paginate(17000);
            }
             
			 
			return view('report.calender')->with('data', $query)
                                ->with("start", @$start)
                                ->with("end", @$end)
                                ->with("seller",$seller)->with("user",$users);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search()
	{   
		$user=\DB::table('users')->where("role","!=","6")->select("id","name")->get();
            return   view('report.calender')->with("user",$user);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
