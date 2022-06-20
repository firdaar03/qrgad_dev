<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsKategoriKonsumable;
use App\Models\Table\Qrgad\MsSubKategoriKonsumable;
use App\Models\View\Qrgad\VwSubKategoriKonsumable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubKategoriKonsumableController extends Controller
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

            $subkategori = VwSubKategoriKonsumable::all()->where('status', 1);
            $breadcrumb = [
                'menu' => "Sub Kategori Konsumable"
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
        
            return view('Qrgad/sub_kategori_konsumable/index', [
                "subkategori" => $subkategori,
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
                "menu" => "Sub Kategori Konsumable",
                "sub-menu" => "Tambah"
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/sub_kategori_konsumable/create', [
                "kategori_konsumable" => MsKategoriKonsumable::all()->where('status', 1),
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

            $kode = MsSubKategoriKonsumable::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "kategori_konsumable" => "required",
                "nama" => "required"
            ]);
    
            $create = MsSubKategoriKonsumable::create([
                "id" => $kode,
                "kategori_konsumable" => $validated['kategori_konsumable'],
                "nama" => $validated['nama'],
                "status" => 1,
                "created_by" => Auth::user()->nama,
            ]);
            
            $alert = '';
    
            if($create){
                $alert = 'success-add-sub kategori konsumable';
            } else {
                $alert = 'danger-add-sub kategori konsumable';
            }
    
            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return redirect('/sub-kategori-konsumable')->with('data', $data);
            
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

            $sub_kategori_konsumable = MsSubKategoriKonsumable::findOrFail($id);
            $breadcrumb = [
                "menu" => "Sub Kategori Konsumable",
                "sub-menu" => "Edit"
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/sub_kategori_konsumable/edit', [
                "sub_kategori_konsumable" => $sub_kategori_konsumable,
                "kategori_konsumable" => MsKategoriKonsumable::all()->where('status', 1),
                "breadcrumbs" => $breadcrumb
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

            $validated = $request->validate([
                "id" => "",
                "nama" => "required",
                "kategori_konsumable" =>"required"
            ]);
    
            $update = MsSubKategoriKonsumable::where('id', $id)->update([
                "kategori_konsumable" => $validated['kategori_konsumable'],
                "nama" => $validated['nama'],
                "updated_by" => Auth::user()->nama,
            ]);
    
            $alert = '';
    
            if($update){
                $alert = 'success-edit-sub kategori konsumable';
            } else {
                $alert = 'danger-edit-sub kategori konsumable';
            }
    
            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return redirect('/sub-kategori-konsumable')->with('data', $data);
            
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

            $update = MsSubKategoriKonsumable::findorFail($id);
        
            $update->status= 0;
            $update->save();
    
            $alert = '';
    
            if($update){
                $alert = 'success-delete-sub kategori konsumable';
            } else {
                $alert = 'danger-delete-sub kategori konsumable';
            }
    
            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return redirect('/sub-kategori-konsumable')->with('data', $data);
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }
}
