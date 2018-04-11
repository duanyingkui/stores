<?php 
	
namespace App\Http\Controllers\User;

use App\Models\Admin\User;
use Illuminate\Http\Request;
use Session;
use Response;
use Log;
use Redirect;


class LoginController{

 	public function index(){
 		return view("login");
 	}

 	public function login(Request $request){

 		if ($request->isMethod('post')) {

 			$name = $request->name;
 			$password = $request->pass;
 			$user = User::where('name',$name)->first();

 			if ($user) {
 				if (encrypt_password($password,$user->salt) == $user->password) {

 					$this->login_success($request,$user);
 					Log::info(['LOGIN SUCCESS' => json_decode($user)]);
 					return Response::json(['status' => 0, 'msg' => '登陆成功']);
 				}else{
 					Log::error(['LOGIN ERROR' => json_encode($user)]);
          	return Response::json(['status' => 1, 'msg' => '用户名或密码错误,请重新输入']);
 				}
 			}else{
 				Log::error(['LOGIN ERROR' => $name . ' & ' . md5(md5($pwd))]);
        return Response::json(['status' => 2, 'msg' => ' ']);
 			}
 		}else{
 			return view('login');
 		}
 	}

 	function login_success($request, $user){
 		$session = $request->session();
    	$session->put('user', $user);
 	}

  	function login_out(Request $request){
    	$session = $request->session();
    	$session->forget('user');
    	return redirect()->action('User\LoginController@index');
  	}

}
