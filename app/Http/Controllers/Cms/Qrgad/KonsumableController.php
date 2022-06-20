<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsKategoriKonsumable;
use App\Models\Table\Qrgad\MsSubKategoriKonsumable;
use App\Models\Table\Qrgad\TbInventory;
use App\Models\Table\Qrgad\TbKonsumable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
                return redirect("/dashboard")->with("error_msg", "Anda tidak memiliki akses");
            }
            return $next($request);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function filterSubKategori($id){
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            $sub_kategori_konsumable = MsSubKategoriKonsumable::all()->where('kategori_konsumable', $id);

            foreach($sub_kategori_konsumable as $skk){
                echo "<option value=".$skk->id." >".$skk->nama."</option>";
            }

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }

    public function create()
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $breadcrumb = [
                "menu" => "Konsumable",
                "sub-menu" => "Tambah"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
        
            return view('Qrgad/konsumable/create', [
                "kategori_konsumable" => MsKategoriKonsumable::all()->where('status', 1),
                "sub_kategori_konsumable" => MsSubKategoriKonsumable::all()->where('status', 1),
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
            $kode = TbKonsumable::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "nama" => "required|unique:tb_konsumables",
                "kategori_konsumable" =>"required",
                "sub_kategori_konsumable" => "required",
                "jenis_satuan" => "required",
                "minimal_stock" => "required|min:1"
            ]);

            $validated['id'] = $kode;
            $create = TbKonsumable::create($validated);

            $alert = '';

            if($create){
                $alert = 'success-add-konsumable';
            } else {
                $alert = 'danger-add-konsumable';
            }

            $data = array(
                "alert" => $alert,
                "konsumable" => $request->nama,
                "id" => $kode
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            if($create){
                return redirect('/inventory/create')->with('data', $data);

            } else{
                return redirect('/konsumable/create')->with('data', $data);
            }
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

            $konsumable = TbKonsumable::findOrFail($id);
            $kategori_konsumable = MsKategoriKonsumable::all()->where('status', 1);
            $sub_kategori_konsumable = MsSubKategoriKonsumable::all()->where('status', 1);

            $breadcrumb = [
                "menu" => "Konsumable",
                "sub-menu" => "Edit"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
    
            return view('Qrgad/konsumable/edit', [
                "k" => $konsumable,
                "kategori_konsumable" => $kategori_konsumable,
                "sub_kategori_konsumable" => $sub_kategori_konsumable,
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
                "kategori_konsumable" =>"required",
                "sub_kategori_konsumable" => "required",
                "jenis_satuan" => "required|min:1",
                "minimal_stock" => "required|min:1"
            ]);


            $update = TbKonsumable::findorFail($id)->update([
                "nama" =>  $validated['nama'],
                "kategori_konsumable" => $validated['kategori_konsumable'],
                "sub_kategori_konsumable" => $validated['sub_kategori_konsumable'],
                "jenis_satuan" => $validated['jenis_satuan'],
                "minimal_stock" => $validated['minimal_stock']
            ]);
            
            $alert = '';
            
            // dd($create);
            if($update){
                $alert = 'success-edit-konsumable';
            } else {
                $alert = 'danger-edit-konsumable';
            }

            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            // dd($alert);
            
            return redirect('/inventory')->with('data', $data);

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
            $deleteinvetory = TbInventory::where('konsumable', $id)->delete();
            $deletekonsumable = TbKonsumable::where('id', $id)->delete();

            $alert = '';

            if($deletekonsumable){
                $alert = 'success-delete-ruangan';
            } else {
                $alert = 'danger-delete-ruangan';
            }

            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
    
            return redirect('/inventory')->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
}