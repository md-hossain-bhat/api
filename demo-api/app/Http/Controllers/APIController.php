<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
class APIController extends Controller
{
    public function getUsers(){
        $users = User::get();
        return response()->json(["users"=>$users]);
    }

    public function getSingleUser($id=null){
        if(empty($id)){
            $users = User::get();
            return response()->json(["users"=>$users]);
        }else{
            $users = User::find($id);
            return response()->json(["users"=>$users]);
        }
    }

    public function addUser(Request $request){
        if($request->isMethod('post')){
            $userData = $request->input();
            // echo "<pre>"; print_r($userData);die;
            $user = new User;
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = bcrypt($userData['password']);
            $user->save();
            return response()->json(["message"=>'user added successfully!']);
        }
    }
}
