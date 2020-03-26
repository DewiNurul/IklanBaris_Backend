<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class BarangController extends Controller
{
   
    public function index()
    {
        try{
	        $data["count"] = Barang::count();
	        $barang = array();

	        foreach (Barang::all() as $p) {
	            $item = [
	                "id"          		=> $p->id,
	                "judul"             => $p->judul,
	                "kategori"  		=> $p->kategori,
                    "harga"    	  		=> $p->harga,
                    "lokasi"    	  	=> $p->lokasi,
                    "deskripsi"    	  	=> $p->deskripsi,
                    "gambar"    	  	    => $p->gambar,
	            ];

	            array_push($barang, $item);
	        }
	        $data["barang"] = $barang;
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
    			'judul'                 => 'required|string|max:255',
				'kategori'			  	=> 'required|string|max:255',
                'harga'			  		=> 'required|string|max:500',
                'lokasi'			  	=> 'required|string|max:255',
                'deskripsi'			  	=> 'required|string|max:255',
                'gambar'		    	=> 'required',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new Barang();
	        $data->judul        = $request->input('judul');
	        $data->kategori     = $request->input('kategori');
            $data->harga        = $request->input('harga');
            $data->lokasi       = $request->input('lokasi');
            $data->deskripsi    = $request->input('deskripsi');
            $file     = $request->file('gambar');
            $fileName = $file->getClientOriginalName();
            $request->file('gambar')->move("image/", $fileName);
            $data->gambar = $fileName;
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data Barang berhasil ditambahkan!'
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
                'judul'                 => 'required|string|max:255',
				'kategori'			  	=> 'required|string|max:255',
                'harga'			  		=> 'required|string|max:500',
                'lokasi'			  	=> 'required|string|max:255',
                'deskripsi'			  	=> 'required|string|max:255',
                'gambar'		    	=> 'required',
          ]);
  
            if($validator->fails()){
                return response()->json([
                    'status'	=> '0',
                    'message'	=> $validator->errors()
                ]);
            }
  
            //proses update data
            $data = Barang::where('id', $id)->first();
            $data->judul        = $request->input('judul');
            $data->kategori     = $request->input('kategori');
            $data->harga        = $request->input('harga');
            $data->lokasi       = $request->input('lokasi');
            $data->deskripsi    = $request->input('deskripsi');
            // $data->gambar         = $request->input('gambar');

            if($request->file('gambar')== "") {
                $data->gambar = $data->gambar;
            } else {
                $file       = $request->file('gambar');
                $fileName   = $file->getClientOriginalName();
                $request->file('gambar')->move("image/", $fileName);
                $data->gambar = $fileName;
            }
            $data->save();
  
            return response()->json([
                'status'	=> '1',
                'message'	=> 'Data Barang berhasil diubah'
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
  
              $delete = Barang::where("id", $id)->delete();
  
              if($delete){
                return response([
                  "status"  => 1,
                    "message"   => "Data Barang berhasil dihapus."
                ]);
              } else {
                return response([
                  "status"  => 0,
                    "message"   => "Data Barang gagal dihapus."
                ]);
              }
              
          } catch(\Exception $e){
              return response([
                  "status"	=> 0,
                  "message"   => $e->getMessage()
              ]);
          }
      }

  



    public function show($id)
    {
        //
    }

}
