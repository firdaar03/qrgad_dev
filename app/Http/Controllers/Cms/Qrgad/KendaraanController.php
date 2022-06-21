<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
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
            if($level != "LV00000001" && $level != "LV00000002") {
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

            $kendaraans = MsKendaraan::all()->where('status', 1);
            $breadcrumb = [
                [
                    'nama' => "Kendaraan",
                    'url' => "/kendaraan"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/kendaraan/index', [
                "kendaraans" => $kendaraans,
                "breadcrumbs" => $breadcrumb
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

            $breadcrumb = [
                [
                    'nama' => "Kendaraan",
                    'url' => "/kendaraan"
                ],
                [
                    'nama' => "Tambah",
                    'url' => "/kendaraan/create"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/kendaraan/create', [
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

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

            $kode = MsKendaraan::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "nama" =>"required",
                "nopol" => "required",
            ]);
            
            $create = MsKendaraan::create([
                "id" => $kode,
                "nama" => $validated['nama'],
                "nopol" =>  $validated['nopol'],
                "status" => 1,
                "created_by" => Auth::user()->nama, 
            ]);
    
            $alert = '';

            if($create){
                $alert = 'success-add-kendaraan';
            } else {
                $alert = 'danger-add-kendaraan';
            }

            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
    
            return redirect('/kendaraan')->with('data', $data);
            

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
            
            $breadcrumb = [
                [
                    'nama' => "Kendaraan",
                    'url' => "/kendaraan"
                ],
                [
                    'nama' => "Edit",
                    'url' => "/kendaraan/".$id."/edit"
                ],
            ];
    
            return view('Qrgad/kendaraan/edit', [
                "kendaraan" => MsKendaraan::findOrFail($id),
                "breadcrumbs" => $breadcrumb
            ]);

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

            $validated = $request->validate([
                "id" => "",
                "nama" =>"required",
                "nopol" => "required",
            ]);
    
            $update = MsKendaraan::where('id', $id)->update([
                "nama" => $validated['nama'],
                "nopol" =>  $validated['nopol'],
                "updated_by" => Auth::user()->nama, 
            ]);
    
            $alert = '';

            if($update){
                $alert = 'success-edit-kendaraan';
            } else {
                $alert = 'danger-edit-kendaraan';
            }

            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
    
            return redirect('/kendaraan')->with('data', $data);

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
            
            $update = MsKendaraan::where('id', $id)->update([
                "status" => 0
            ]);

            $alert = '';

            if($update){
                $alert = 'success-delete-kendaraan';
            } else {
                $alert = 'danger-delete-kendaraan';
            }

            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
    
            return redirect('/kendaraan')->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }
}
