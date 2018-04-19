<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/26
 * Time: 21:32
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class StaffController extends Controller
{
	function getAllStaff(Request $request){
		$pagesize = $request->input('pagesize',5);
		$staff = staff::join('user','user.object_id','=','staff.id')
		->select('staff.name','user.type','')
	}
}