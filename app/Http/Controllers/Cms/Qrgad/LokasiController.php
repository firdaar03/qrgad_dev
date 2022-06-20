<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LokasiController extends Controller
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
            if($level != "LV00000001" && $level != "LV00000002") {
                return redirect("/dashboard")->with("error_msg", "Anda tidak memiliki akses");
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
                'menu' => "Lokasi",
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/lokasi/index', [
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

            return view('Qrgad/lokasi/read', [
                "lokasi" => MsLokasi::where('status', 1)->get()
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

            return view('Qrgad/lokasi/create')->with('data', $data);
            
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
            $kode = MsLokasi::idOtomatis();

            $create = MsLokasi::create([
                'id' => $kode,
                'nama' => $request->nama,
                'created_by' => Auth::user()->nama,
                'status' => 1,
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

            return view('Qrgad/lokasi/edit', [
                "lokasi" =>  MsLokasi::findOrFail($id)
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

            $lokasi = MsLokasi::findOrFail($id);
            $lokasi->nama = $request->nama;
            $lokasi->save();

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

            return view('Qrgad/lokasi/delete', [
                'id' => $id
            ])->with('data',$data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function destroy($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->d==1){
            $update = MsLokasi::find($id);
        
            $update->status= 0;
            $update->save();

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
}
