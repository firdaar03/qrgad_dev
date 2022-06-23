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
        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function filterSubKategori($id){
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            $sub_kategori_konsumable = MsSubKategoriKonsumable::all()->where('kategori_konsumable', $id)->where('status', 1);

            // foreach($sub_kategori_konsumable as $skk){
            //     echo "<option value=".$skk->id." {!! old('sub_kategori_konsumable') != $skk->id ?  : selected !!} >".$skk->nama."</option>";
            // }
            
            $data = $sub_kategori_konsumable;
            return $data;

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }

    public function create()
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            $breadcrumb = [
                [
                    'nama' => "Tambah Konsumable",
                    'url' => "/konsumable/create"
                ],
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

            $create = TbKonsumable::create([
                "id" => $kode,
                "nama" => $validated['nama'],
                "kategori_konsumable" => $validated['kategori_konsumable'],
                "sub_kategori_konsumable" => $validated['sub_kategori_konsumable'],
                "jenis_satuan" => $validated['jenis_satuan'],
                "minimal_stock" => $validated['minimal_stock']
            ]);

            if($create){
                return redirect('/inventory/create')->with([
                    "id" => $kode,
                    "konsumable" => $request->nama,
                    "alert", 'success-add-konsumable'
                ]);

            } else{

                return back()->withInput($request->input())->with('alert', 'danger-add-konsumable');
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
                [
                    'nama' => "Edit Konsumable",
                    'url' => "/konsumable/create"
                ],
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
            
            if($update){
                $alert = 'success-edit-konsumable';
            } else {
                $alert = 'danger-edit-konsumable';
            }
            
            return redirect('/inventory')->with('alert', $alert);

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
                $alert = 'success-delete-konsumable';
            } else {
                $alert = 'danger-delete-konsumable';
            }
    
            return redirect('/inventory')->with('alert', $alert);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
}
