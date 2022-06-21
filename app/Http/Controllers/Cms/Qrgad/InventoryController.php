<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\TbInventory;
use App\Models\Table\Qrgad\TbKonsumable;
use App\Models\View\Qrgad\VwTabelInventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
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
            $tabelinventory = VwTabelInventory::all();
            $breadcrumb = [
                [
                    'nama' => "Table Inventory",
                    'url' => "/inventory"
                ],
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
        
            return view('Qrgad/inventory/index', [
                "tabelinventory" => $tabelinventory,
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
                    'nama' => "Table Inventory",
                    'url' => "/inventory"
                ],
                [
                    'nama' => "Tambah",
                    'url' => "/inventory/create"
                ],
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
       
            return view('Qrgad/inventory/create', [
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function tambah($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            
            $konsumable = TbKonsumable::findOrFail($id);
            $breadcrumb = [
                [
                    'nama' => "Table Inventory",
                    'url' => "/inventory"
                ],
                [
                    'nama' => "Tambah",
                    'url' => "/inventory-tambah/".$id
                ],
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return view('Qrgad/inventory/create', [
                "breadcrumbs" => $breadcrumb,
                "k" => $konsumable,
                "konsumable" => $konsumable->nama,
                "id" => $id
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
            $kode = TbInventory::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "konsumable" => "",
                "jumlah_stock" =>"required",
                "nama_toko" => "required",
                "harga_item" => "required"
            ]);

            $validated['username'] = Auth::user()->username;
            $validated['id'] = $kode;

            $create = TbInventory::create($validated);

            $alert = '';

            if($create){
                $alert = 'success-add-inventory';
            } else {
                $alert = 'danger-add-inventory';
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

    public function report()
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){
            $breadcrumb = [
                [
                    'nama' => "Report Inventory",
                    'url' => "/inventory-report"
                ],
            ];

            if (request()->start_date != "" || request()->end_date != ""){
                if(request()->start_date < request()->end_date){
                    $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                    $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                    $tabelinventory = VwTabelInventory::whereBetween('last_entry',[$start_date,$end_date])->get();
                } else {
                    $alert = 'danger-tanggalgagal- ';
                    $data = array(
                        "alert" => $alert,
                    );
                    return redirect('/report-inventory')->with('data', $data);
                }
            } else {
                $tabelinventory = VwTabelInventory::all();
            }
        
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/inventory/report', [
                "tabelinventory" => $tabelinventory,
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
