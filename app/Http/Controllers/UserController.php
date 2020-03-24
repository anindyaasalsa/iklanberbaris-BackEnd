<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function index()
    {
    	try{
	        $data["count"] = User::count();
	        $user = array();

	        foreach (User::all() as $p) {
	            $item = [
	                "id"          => $p->id,
	                "username"          => $p->username,
	                "password"          => $p->password,
	                "nama_admin"        => $p->nama_admin
	            ];

	            array_push($user, $item);
	        }
	        $data["user"] = $user;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function getAll($limit = 10, $offset = 0)
    {
    	try{
	        $data["count"] = User::count();
	        $user = array();

	        foreach (User::take($limit)->skip($offset)->get() as $p) {
	            $item = [
	                "id"          => $p->id,
	                "username"          => $p->username,
	                "password"          => $p->password,
	                "nama_admin"        => $p->nama_admin
	            ];

	            array_push($user, $item);
	        }
	        $data["user"] = $user;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function store(Request $request)
    {
      try{
    		$validator = Validator::make($request->all(), [
    			'id'      => 'required|integer|max:255',
				'username'	    => 'required|string|max:255',
				'password'		=> 'required|string|max:255',
				'nama_admin'	=> 'required|string|max:255',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new User();
	        $data->id = $request->input('id');
	        $data->username = $request->input('username');
	        $data->password = $request->input('password');
	        $data->nama_admin = $request->input('nama_admin');
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data admin berhasil ditambahkan!'
    		], 201);

      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
  	}


    public function update(Request $request, $id)
    {
      try {
      	$validator = Validator::make($request->all(), [
			'id'            => 'required|integer|max:255',
			'username'			  => 'required|string|max:255',
			'password'			  => 'required|string|max:255',
			'nama_admin'		  => 'required|string|max:255',
		]);

      	if($validator->fails()){
      		return response()->json([
      			'status'	=> '0',
      			'message'	=> $validator->errors()
      		]);
      	}

      	//proses update data
      	$data = User::where('id', $id)->first();
        $data->username = $request->input('username');
        $data->password = $request->input('password');
        $data->nama_admin = $request->input('nama_admin');
        $data->save();

      	return response()->json([
      		'status'	=> '1',
      		'message'	=> 'Data Admin berhasil diubah'
      	]);
        
      } catch(\Exception $e){
          return response()->json([
              'status' => '0',
              'message' => $e->getMessage()
          ]);
      }
    }

    public function delete($id)
    {
        try{

            $delete = User::where("id", $id)->delete();

            if($delete){
              return response([
              	"status"	=> 1,
                  "message"   => "Data Admin berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data Admin gagal dihapus."
              ]);
            }
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
