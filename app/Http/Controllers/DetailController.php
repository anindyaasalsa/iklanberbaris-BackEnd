<?php

namespace App\Http\Controllers;
use App\Detail;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Validator;

class DetailController extends Controller
{
    
    public function index()
    {
    	try{
	        $data["count"] = Detail::count();
	        $detail = array();

	        foreach (Detail::all() as $p) {
	            $item = [
	                "id"                        => $p->id,
	                "judul"                     => $p->judul,	                
	                "deskripsi_iklan"           => $p->deskripsi_iklan,
	                "harga"                     => $p->harga,
	                "kontak"                    => $p->kontak,
	                "pemilik_iklan"             => $p->pemilik_iklan,
					"kategori"                  => $p->kategori,
					"gambar"				    => $p->gambar,
	                "created_at"                => $p->created_at,
	                "updated_at"                => $p->updated_at
	            ];

	            array_push($detail, $item);
	        }
	        $data["detail"] = $detail;
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
	        $data["count"] = Detail::count();
	        $detail = array();

	        foreach (Detail::take($limit)->skip($offset)->get() as $p) {
	            $item = [
                    "id"                        => $p->id,
	                "judul"                     => $p->judul,	                
	                "deskripsi_iklan"           => $p->deskripsi_iklan,
	                "harga"                     => $p->harga,
	                "kontak"                    => $p->kontak,
	                "pemilik_iklan"             => $p->pemilik_iklan,
	                "kategori"                  => $p->kategori,
					"gambar"				    => $p->gambar,
	                "created_at"                => $p->created_at,
	                "updated_at"                => $p->updated_at
	            ];

	            array_push($detail, $item);
	        }
	        $data["detail"] = $detail;
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }
	// image|mimes:jpeg,png,jpg|
    public function store(Request $request)
    {
      try{
    		$validator = Validator::make($request->all(), [
                'judul'              => 'required|string|max:255',
				'deskripsi_iklan'	 => 'required|string|max:255',
				'harga'			     => 'required|string|max:255',
				'kontak'			 => 'required|string|max:15',
				'pemilik_iklan'		 => 'required|string|max:255',
				'kategori'			 => 'required|string|max:255',
				'gambar' 			 => 'required|string|max:2048',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new Detail();
	        $data->judul = $request->input('judul');
	        $data->deskripsi_iklan = $request->input('deskripsi_iklan');
	        $data->harga = $request->input('harga');
	        $data->kontak = $request->input('kontak');
	        $data->pemilik_iklan = $request->input('pemilik_iklan');
			$data->kategori = $request->input('kategori');
			$data->gambar = $request->input('gambar');
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data iklan berhasil ditambahkan!'
    		], 201);

      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
  	}

	//   image|mimes:jpeg,png,jpg|
    public function update(Request $request, $id)
    {
      try {
      	$validator = Validator::make($request->all(), [
			    'judul'              => 'required|string|max:255',
				'deskripsi_iklan'	 => 'required|string|max:255',
				'harga'			     => 'required|string|max:255',
				'kontak'			 => 'required|string|max:15',
				'pemilik_iklan'		 => 'required|string|max:255',
				'kategori'			 => 'required|string|max:255',
				'gambar' 			 => 'required|string|max:2048',
		]);

      	if($validator->fails()){
      		return response()->json([
      			'status'	=> '0',
      			'message'	=> $validator->errors()
      		]);
      	}

      	//proses update data
      	$data = Detail::where('id', $id)->first();
          $data->judul = $request->input('judul');
          $data->deskripsi_iklan = $request->input('deskripsi_iklan');
          $data->harga = $request->input('harga');
          $data->kontak = $request->input('kontak');
          $data->pemilik_iklan = $request->input('pemilik_iklan');
          $data->kategori = $request->input('kategori');
		  $data->gambar = $request->input('gambar');
		$data->save();

      	return response()->json([
      		'status'	=> '1',
      		'message'	=> 'Data iklan berhasil diubah'
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

            $delete = Detail::where("id", $id)->delete();

            if($delete){
              return response([
              	"status"	=> 1,
                  "message"   => "Data iklan berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data iklan gagal dihapus."
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
