<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use Validator;

class APIController extends Controller
{
    public function getUsers(){
        $users = User::get();
        return response()->json(["users"=>$users],200);
    }

    public function getSingleUser($id=null){
        if(empty($id)){
            $users = User::get();
            return response()->json(["users"=>$users],200);
        }else{
            $users = User::find($id);
            return response()->json(["users"=>$users],200);
        }
    }

    public function addUser(Request $request){
        if($request->isMethod('post')){
            $userData = $request->input();
            // echo "<pre>"; print_r($userData);die;
            //api validatio and empty data check
            // if(empty($userData['name'])|| empty($userData['email'])||empty($userData['password'])){
            //    $error_message ="please enter user details";
            // }
            // if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            //     $error_message ="please enter valid email";
            // }
            // $useCount = User::where('email',$userData['email'])->count();
            // if($useCount > 0){
            //     $error_message ="Email already exist!";
            // }

            // if(isset($error_message)&&!empty($error_message)){
            //     return response()->json(['status'=>false,'message'=>$error_message],422); 
            // }
            //advance validation api
            $rulse = [
                "name"=>"required|regex:/(^([a-zA-z]+)(\d+)?$)/u",
                "email"=>"required|email|unique:users",
                "password"=>"required"
            ];
            $customMessage = [
                'name.required' =>'Name is required',
                'email.required' =>'Email is required',
                'email.email' =>'valid email is required',
                'name.unique' =>'Email has been taken exist!',
                'name.password' =>'Password is required'
            ];
            $validator = Validator::make($userData,$rulse,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422); 
            }
            $user = new User;
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = bcrypt($userData['password']);
            $user->save();
            return response()->json(["message"=>'user added successfully!'],201);
        }
    }
    
    public function addMultipleUsers(Request $request){
        if($request->isMethod('post')){
            $userData = $request->input();
            // echo "<pre>"; print_r($userData);die;
            $rulse = [
                "users.*.name"=>"required|regex:/(^([a-zA-z]+)(\d+)?$)/u",
                "users.*.email"=>"required|email|unique:users",
                "users.*.password"=>"required"
            ];
            $customMessage = [
                'users.*.name.required' =>'Name is required',
                'users.*.email.required' =>'Email is required',
                'users.*.email.email' =>'valid email is required',
                'users.*.name.unique' =>'Email has been taken exist!',
                'users.*.name.password' =>'Password is required'
            ];
            $validator = Validator::make($userData,$rulse,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422); 
            }
            foreach($userData['users'] as $key =>$value){
                $user = new User;
                $user->name = $value['name'];
                $user->email = $value['email'];
                $user->password = bcrypt($value['password']);
                $user->save();
            }
            return response()->json(["message"=>'user added successfully!'],201);
        }
    }

    public function updateUserDetails(Request $request,$id){
        if($request->isMethod("put")){
            $userData = $request->input();
            // echo "<pre>"; print_r($userData);die;
            $rulse = [
                "name"=>"required|regex:/(^([a-zA-z]+)(\d+)?$)/u",
                "email"=>"required|email|unique:users",
                "password"=>"required"
            ];
            $customMessage = [
                'name.required' =>'Name is required',
                'email.required' =>'Email is required',
                'email.email' =>'valid email is required',
                'name.unique' =>'Email has been taken exist!',
                'name.password' =>'Password is required'
            ];
            $validator = Validator::make($userData,$rulse,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422); 
            }
            
            User::where('id',$id)->update(['name'=>$userData['name'],'email'=>$userData['email'],'password'=>bcrypt($userData['password'])]);
            return response()->json(["message"=>'user details updated successfully!'],202);
        }
    }
    public function updateUser(Request $request,$id){
        if($request->isMethod("patch")){
            $userData = $request->input();
            // echo "<pre>"; print_r($userData);die;
            $rulse = [
                "name"=>"required|regex:/(^([a-zA-z]+)(\d+)?$)/u"
            ];
            $customMessage = [
                'name.required' =>'Name is required'
            ];
            $validator = Validator::make($userData,$rulse,$customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422); 
            }
            User::where('id',$id)->update(['name'=>$userData['name']]);
            return response()->json(["message"=>'user updated successfully!'],202);

        }
    }

    public function deleteUser($id){
        User::where('id',$id)->delete();
        return response()->json(["message"=>'user delete successfully!'],202);
    }

    public function deleteUserJon(Request $request){
        if($request->isMethod('delete')){
            $userData = $request->all();
            // echo "<pre>"; print_r($userData);die;
            User::where('id',$userData['id'])->delete();
            return response()->json(["message"=>'user delete successfully!'],200);
        }
    }
    public function deleteMultipleUser($ids){
        $ids = explode(',',$ids);
        // echo "<pre>"; print_r($ids);die;
        User::whereIn('id',$ids)->delete();
        return response()->json(["message"=>'user delete successfully!'],202);
    }

    public function deleteMultipleUserJson(Request $request){
        if($request->isMethod('delete')){
            $userData = $request->all();
            // echo "<pre>"; print_r($userData);die;
            User::whereIn('id',$userData['ids'])->delete();
            return response()->json(["message"=>'user delete successfully!'],202);
        }
    }
}
