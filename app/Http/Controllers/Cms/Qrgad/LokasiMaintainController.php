<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsLokasiMaintain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LokasiMaintainController extends Controller
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
                    'nama' => "Lokasi Maintain",
                    'url' => "/lokasi-maintain"
                ],
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/lokasi_maintain/index', [
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

            return view('Qrgad/lokasi_maintain/read', [
                "lokasi_maintain" => MsLokasiMaintain::where('status', 1)->get()
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

            return view('Qrgad/lokasi_maintain/create')->with('data', $data);

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
            $kode = MsLokasiMaintain::idOtomatis();

            $create = MsLokasiMaintain::create([
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


            return view('Qrgad/lokasi_maintain/edit', [
                "lokasi_maintain" =>  MsLokasiMaintain::findOrFail($id)
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
                
            $lokasim = MsLokasiMaintain::findOrFail($id);
            $lokasim->nama = $request->nama;
            $lokasim->save();

        
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

            return view('Qrgad/lokasi_maintain/delete', [
                'id' => $id
            ])->with('data',$data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }    
    }
    
    public function destroy($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->d==1){
            $update = MsLokasiMaintain::find($id);
        
            $update->status= 0;
            $update->save();

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
}
