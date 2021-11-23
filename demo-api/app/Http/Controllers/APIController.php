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
}
