<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
class AuthController extends Controller
{
    public function signup(Request $request){
        $requestForReg = $request;
        $request = $request->all();

        $validator = \Validator::make($request, [
            'name' => 'required',
            'email' => 'required|string|unique:users',
            'phone' => 'required|string',
            'nid' => 'required|string|unique:users',
            'password' => 'required|string|confirmed'
        ], [
            
            'email.unique' => 'Your email address is already used, Please Login or use another',    
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
            
            ],501);
        }

        $requestForReg->validate([
            'name' => 'required',
            'email' => 'required|string|unique:users',
            'phone' => 'required|string',
            'nid' => 'required|string|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        
        

        $user = new User([
            'name' => $requestForReg->name,
            'email' => $requestForReg->email,
            'phone' => $requestForReg->phone,
            'nid' => $requestForReg->nid,
            'password' => bcrypt($requestForReg->password)
            
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!',
            'name' => $requestForReg->name,
            'email' => $requestForReg->email,
            'phone' => $requestForReg->phone,
            'nid' => $requestForReg->nid,
            'password' => bcrypt($requestForReg->password)
        ], 201);
        
        
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'nid' => $user->nid

        ]);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request){
        return response()->json($request->user());
    }

    /*public function ShowUserOrderedList(Request $request)
    {
       // $show = DB::table('orders')->where('user_id',$id)->Order::all();
       // $user = $authUser->user();
      // $show = DB::table('orders')->get(); //all
        $user = $request->user();
        $show = DB::table('orders')->where('user_id',$user->id)->get();
        return response()->json($show);
         
    }
    */

   
}
