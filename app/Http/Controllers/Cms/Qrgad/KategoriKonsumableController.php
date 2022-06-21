<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsKategoriKonsumable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriKonsumableController extends Controller
{
    public function __construct()
    {
        // hak akses : admin dan super gad
        // $this->middleware(function ($request, $next) {
        //     if($this->permissionMenu('aplikasi-management') == 0) {
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
            $breadcrumb = [
                [
                    'nama' => "Kategori Konsumable",
                    'url' => "/kategori-konsumable"
                ],
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return view('Qrgad/kategori_konsumable/index', [
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function read()
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/kategori_konsumable/read', [
                "kategori_konsumable" => MsKategoriKonsumable::where('status', 1)->get()
            ])->with('data', $data);

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
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/kategori_konsumable/create')->with('data', $data);
            
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
            $kode = MsKategoriKonsumable::idOtomatis();

            $create = MsKategoriKonsumable::create([
                'id' => $kode,
                'nama' => $request->nama,
                'status' => 1,
                "created_by" => Auth::user()->nama,
            ]);

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
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/kategori_konsumable/edit', [
                "kategori_konsumable" =>  MsKategoriKonsumable::findOrFail($id)
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
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

            $kategori_konsumable = MsKategoriKonsumable::findOrFail($id);
            $kategori_konsumable->nama = $request->nama;
            $kategori_konsumable->updated_by = Auth::user()->nama;
            $kategori_konsumable->save();

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

    public function delete($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->d==1){
            
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            return view('Qrgad/kategori_konsumable/delete', [
                'id' => $id
            ])->with('data',$data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function destroy($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->d==1){
            $update = MsKategoriKonsumable::find($id);
        
            $update->status= 0;
            $update->save();

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
}
