<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\TbKeranjangKonsumable;
use App\Models\Table\Qrgad\TbKonsumable;
use App\Models\View\Qrgad\VwTabelInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangKonsumableController extends Controller
{
    public function __construct()
    {
        // hak akses : admin dan super gad

        // $this->middleware(function ($request, $next) {
        //     if($this->permissionMenu('aplikasi-management')) {
        //         return redirect("/")->with("error_msg", "Akses ditolak");
        //     }
        //     return $next($request);
        // });

        $this->middleware(function ($request, $next) {
            
            $level = Auth::user()->level;
            if($level != "LV00000001" && $level != "LV00000002" ) {
                return redirect("/dashboard")->with("data", [
                    "alert" => "danger-notallowed-Anda tidak memiliki akses"
                ]);
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keranjang = TbKeranjangKonsumable::all()->where("username", Auth::user()->username);

            return view('Qrgad/keranjang/index', [
                "keranjang" => $keranjang,
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function read($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keranjang = TbKeranjangKonsumable::all()->where("username", Auth::user()->username)->where('keluhan', $id);

            return view('Qrgad/keranjang/index', [
                "keranjang" => $keranjang,
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function view()
    {
         // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keranjang = TbKeranjangKonsumable::all()->where("username", Auth::user()->username);

            return view('Qrgad/keranjang/view', [
                "keranjang" => $keranjang,
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function check()
    {
         // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keranjang = TbKeranjangKonsumable::all()->where("username", Auth::user()->username);

            if($keranjang != '' && $keranjang != '[]'){
                return true; 
            } else { 
                return false;
            }

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            
            $kode = TbKeranjangKonsumable::idOtomatis();
            $konsumable = TbKonsumable::where('id', $request->konsumable)->first();
            $keranjang = TbKeranjangKonsumable::where([
                "username" => Auth::user()->username,
                "id_konsumable" => $request->konsumable
            ])->first();

            if($keranjang != ''){
                echo 'err_add_konsumable';
            } else {
                $create = TbKeranjangKonsumable::create([
                    'id' => $kode,
                    'keluhan' => $request->keluhan,
                    'id_konsumable' => $request->konsumable,
                    'konsumable' => $konsumable->nama,
                    'jumlah' => $request->jumlah,
                    'username' => Auth::user()->username
                ]);
            }
    
            // $create = TbKeranjangKonsumable::create([
            //     'id' => $kode,
            //     'keluhan' => $request->keluhan,
            //     'id_konsumable' => $request->konsumable,
            //     'konsumable' => $konsumable->nama_konsumable,
            //     'jumlah' => $request->jumlah,
            //     'username' => Auth::user()->username
            // ]);


        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
            
            $keranjang = TbKeranjangKonsumable::findOrFail($id);

            $konsumable = VwTabelInventory::where('id_konsumable', $keranjang->id_konsumable)->first();

            $limit = $konsumable->stock - $konsumable->minimal_stock; 

            $new_jumlah = $keranjang->jumlah + $request->amount;

            if($new_jumlah > $limit){ //jika jumlah item keranjang baru melebihi stok yang tersedia
                echo 'err_add_amount';
            } else {
                $keranjang->jumlah = $new_jumlah;
                $keranjang->save();
            }

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->d==1){
            
            $update = TbKeranjangKonsumable::where('id', $id)->delete();
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
}
