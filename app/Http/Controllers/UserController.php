<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
			if(!$token = JWTAuth::attempt($credentials)){
				return response()->json([
						'logged' 	=>  false,
						'message' 	=> 'Invalid email and password'
					]);
			}
		} catch(JWTException $e){
			return response()->json([
						'logged' 	=> false,
						'message' 	=> 'Generate Token Failed'
					]);
		}

		return response()->json([
					"logged"    => true,
                    "token"     => $token,
                    "message" 	=> 'Login berhasil'
		]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'nama'       => 'required|string|max:255',
			'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:5',
        
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> 0,
				'message'	=> $validator->errors()->toJson()
			]);
		}

		$user = new User();
		$user->nama      	= $request->nama;
        $user->email 		= $request->email;
		$user->password	    = Hash::make($request->password);
		$user->save();

		$token = JWTAuth::fromUser($user);

		return response()->json([
			'status'	=> '1',
			'message'	=> 'Admin berhasil terregistrasi'
		], 201);
    }

    public function index(){
		try{
        $data["count"] = User::count();
        $user = array();

        foreach (User::all() as $p) {
            $item = [
                "id"          => $p->id,
                "nama"        => $p->nama,
                "email"    	  => $p->email,
                "created_at"  => $p->created_at,
                "updated_at"  => $p->updated_at
            ];

            array_push($user, $item);
        }
        $data["user"] = $user;
        $data["status"] = 1;
		return response($data);
		
	}catch(\Exception $e){
		return response()->json([
		  'status' => '0',
		  'message' => $e->getMessage()
		]);
	  }
	}

    public function delete($id)
    {
        try{

            User::where("id", $id)->delete();

            return response([
            	"status"	=> 1,
                "message"   => "Data berhasil dihapus."
            ]);
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }

    public function ubah(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama'       => 'required|string|max:255',
			'email'		 => 'required|string|email|max:255',
            'password'	 => 'required|string|min:5',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> '0',
				'message'	=> $validator->errors()
			]);
		}

		//proses update data
		$user = User::where('id', $request->id)->first();
		$user->nama 	    = $request->nama;
		$user->email 		= $request->email;
		$user->password	    = Hash::make($request->password);
        $user->save();


		return response()->json([
			'status'	=> '1',
			'message'	=> 'Petugas berhasil diubah'
		], 201);
    }
    
    public function store(Request $request) {
        $user = new User([
          'nama'          => $request->nama,
          'email'       => $request->email,
          'password'    => $request->password,
        ]);

        $user->save();
        return response()->json([
			'status'	=> '1',
			'message'	=> 'Petugas berhasil ditambah'
        ], 201);    
	}
 
   
}
