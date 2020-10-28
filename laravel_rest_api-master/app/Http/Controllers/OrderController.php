<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class OrderController extends Controller
{
    public function AuthUserOrder(Request $request){
        //$request->user()->token();
        
        $user = $request->user();
        echo $request->user()->token()->id;
        //echo $user;
        $request->validate([
            
            'product_catagory' => 'string',
            'product_name' => 'string',
            'quantity' => 'string',
            'payment_status' => 'string',
            'payment_option' => 'string'
        ]);

        $user = new Order([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'product_catagory' => $request->product_catagory,
            'product_name' =>$request->product_name,
            'quantity' => $request->quantity,
            'payment_status' => $request->payment_status,
            'payment_option' => $request->payment_option,
            'order_token' => $request->user()->token()->id
            
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created order!',
            'user_id' => $user->user_id,
            'name' => $user->name,
            'email' => $user->email,
            'product_catagory' => $request->product_catagory,
            'product_name' =>$request->product_name,
            'quantity' => $request->quantity,
            'payment_status' => $request->payment_status,
            'payment_option' => $request->payment_option,
            'order_token' => $request->user()->token()->id
        ], 201);
    }

    public function userOrderedList(Order $order){  
        return [
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'product_catagory' => $this->product_catagory,
            'product_name' => $this->product_name,
            'quantity' => $this->quantity,
            'payment_status' => $this->payment_status,
            'payment_option' => $this->payment_option,
        ];

    }

    
    public function user(Request $request){
        return response()->json($request->user());
    }
   
}
