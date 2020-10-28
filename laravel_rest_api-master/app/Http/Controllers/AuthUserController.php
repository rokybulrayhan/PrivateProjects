<?php

namespace App\Http\Controllers;

use App\AuthUser;
use Illuminate\Http\Request;
use DB;

class AuthUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function show(AuthUser $authUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthUser $authUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthUser $authUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuthUser  $authUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthUser $authUser)
    {
        //
    }

    public function CurrentActiveUser(Request $request)
    {
        //$request->user()->token();
        $user = $request->user();
        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'nid' => $user->nid
        ]);
    }
  /* public function ShowAuthOrderedList($id)
    {
       // $show = DB::table('orders')->where('user_id',$id)->Order::all();
       // $user = $authUser->user();
      // $show = DB::table('orders')->get(); //all
        $user = $request->user();
        $show = DB::table('orders')->where('user_id',$id)->get();
        return response()->json($show);
         
    }
    */

    public function ShowUserOrderedFullList(Request $request)
    {
       // $show = DB::table('orders')->where('user_id',$id)->Order::all();
       // $user = $authUser->user();
      // $show = DB::table('orders')->get(); //all
        $user = $request->user();
        $show = DB::table('orders')->where('user_id',$user->id)->get();
        return response()->json($show);
         
    }

    public function ShowAuthOrderedList(Request $request)
    { 
       $user = $request->user();
       $show = DB::table('orders')->where('user_id',$user->id)->get();
       $myArray = [];
        for($i=0 ; $i<sizeof($show) ; $i++){
          if($show[$i]->order_token === $user->token()->id)
            {         
               array_push($myArray,$show[$i]);                 
            }
        }
        return response()->json($myArray);
              
    }
    
    public function ShowAuthOrderedListProductDetails(Request $request, $id)
    { 
     
       $user = $request->user();
       $show = DB::table('orders')->where('user_id',$user->id)->get();
       $myArray = []; 
       for($i=0 ; $i<sizeof($show) ; $i++){
          if(($show[$i]->order_token == $user->token()->id)
          && ($show[$i]->id == $id))
            {         
               array_push($myArray,$show[$i]);                 
            }
        }
       return response()->json($myArray);
              
    }

    
    public function AuthUserOrderdSingleProductDelete(Request $request, $id)
    { 
     
       $user = $request->user();
       $show = DB::table('orders')->where('user_id',$user->id)->get();
       $myArray = []; 
       for($i=0 ; $i<sizeof($show) ; $i++){
          if(($show[$i]->order_token == $user->token()->id)
          && ($show[$i]->id == $id))
            {         
                DB::table('orders')->where('id',$id)->delete(); 
                return response()->json([
                    'massage' => 'this product was deleted',
                ]);                
            }
        }
      
              
    }
}
