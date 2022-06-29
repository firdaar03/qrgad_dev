<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsSupir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupirController extends Controller
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

            $supirs = MsSupir::all()->where('status', 1)->whereNotNull('kontak');
            $breadcrumb = [
                [
                    'nama' => "Driver",
                    'url' => "/supir"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/supir/index', [
                "supirs" => $supirs,
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
                    'nama' => "Driver",
                    'url' => "/supir"
                ],
                [
                    'nama' => "Tambah",
                    'url' => "/supir/create"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/supir/create', [
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

            $kode = MsSupir::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "nama" =>"required",
                "kontak" =>"required",
            ]);
            
            $create = MsSupir::create([
                "id" => $kode,
                "nama" => $validated['nama'],
                "kontak" =>  "62".$validated['kontak'],
                "status" => 1,
                "created_by" => Auth::user()->nama, 
            ]);
    
            $alert = '';

            if($create){
                $alert = 'success-add-driver';
            } else {
                $alert = 'danger-add-driver';
            }

            return redirect('/supir')->with('alert', $alert);
            

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
                    'nama' => "Driver",
                    'url' => "/supir"
                ],
                [
                    'nama' => "Edit",
                    'url' => "/supir/".$id."/edit"
                ],
            ];
    
            return view('Qrgad/supir/edit', [
                "supir" => MsSupir::findOrFail($id),
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
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $validated = $request->validate([
                "id" => "",
                "nama" =>"required",
                "kontak" =>"required",
            ]);
            
            $update = MsSupir::where('id', $id)->update([
                "nama" => $validated['nama'],
                "kontak" =>  "+62".$validated['kontak'],
                "updated_by" => Auth::user()->nama, 
            ]);
    
            $alert = '';

            if($update){
                $alert = 'success-edit-driver';
            } else {
                $alert = 'danger-edit-driver';
            }

            return redirect('/supir')->with('alert', $alert);
            

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
            
            $update = MsSupir::where('id', $id)->update([
                "status" => 0
            ]);

            $alert = '';

            if($update){
                $alert = 'success-delete-driver';
            } else {
                $alert = 'danger-delete-driver';
            }

            return redirect('/supir')->with('alert', $alert);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
}
