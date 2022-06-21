<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsAset;
use App\Models\Table\Qrgad\MsGrupAset;
use App\Models\Table\Qrgad\MsKategoriKonsumable;
use App\Models\Table\Qrgad\MsLokasiMaintain;
use App\Models\Table\Qrgad\MsSubGrupAset;
use App\Models\Table\Qrgad\TbInventory;
use App\Models\Table\Qrgad\TbItemOut;
use App\Models\Table\Qrgad\TbKeluhan;
use App\Models\Table\Qrgad\TbKeranjangKonsumable;
use App\Models\Table\Qrgad\TbKonsumable;
use App\Models\Table\Qrgad\TbResponKeluhan;
use App\Models\View\Qrgad\VwItemOut;
use App\Models\View\Qrgad\VwKeluhan;
use App\Models\view\Qrgad\VwKonsumableInventoris;
use App\Models\View\Qrgad\VwTabelInventory;
use App\Models\View\Qrgad\VwTbItemOut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeluhanController extends Controller
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
            if($level != "LV00000001" && $level != "LV00000002" && $level != "LV00000004" ) {
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

            $keluhan = VwKeluhan::all()->where('username', Auth::user()->username);
            $breadcrumb = [
                [
                    'nama' => "Keluhan",
                    'url' => "/keluhan"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/keluhan/index', [
                "keluhan" => $keluhan,
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function dashboard()
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $breadcrumb = [
                [
                    'nama' => "Dashboard Keluhan",
                    'url' => "/keluhan-dashboard"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/keluhan/dashboard', [
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function read($type){

        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keluhan = '';

            if($type == 'request'){
                $keluhan = VwKeluhan::all()->where('status', 0);
                return view('Qrgad/keluhan/request', [
                    "keluhan" => $keluhan
                ]);
            } else {
                $keluhan = VwKeluhan::where('status', 1)->orWhere('status', 2)->get();
                return view('Qrgad/keluhan/response', [
                    "keluhan" => $keluhan
                ]);
            }


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
                    'nama' => "Keluhan",
                    'url' => "/keluhan"
                ],
                [
                    'nama' => "Tambah",
                    'url' => "/keluhan/create"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/keluhan/create', [
                "lokasi" => MsLokasiMaintain::all()->where('status', 1),
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function getLimitStock($id){
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $konsumable = VwTabelInventory::all()->where('id_konsumable', $id)->first();

            echo $konsumable->stock-$konsumable->minimal_stock;

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function inputAction($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $breadcrumb = [
                [
                    'nama' => "Dashboard Keluhan",
                    'url' => "/keluhan-dashboard"
                ],
                [
                    'nama' => "Aksi",
                    'url' => "/keluhan-dashboard-input-action/".$id
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            TbKeranjangKonsumable::where('username', Auth::user()->username)->delete();
           
            return view('Qrgad/keluhan/action', [
                "keluhan" => VwKeluhan::findOrFail($id),
                "konsumable" => VwTabelInventory::all(),
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function inputClose($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $breadcrumb = [
                [
                    'nama' => "Dashboard Keluhan",
                    'url' => "/keluhan-dashboard"
                ],
                [
                    'nama' => "Tutup Keluhan",
                    'url' => "/keluhan-dashboard-input-close/".$id
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/keluhan/close', [
                "keluhan" => VwKeluhan::findOrFail($id),
                "grup_asets" => MsGrupAset::all()->where('status', 1),
                "sub_grup_asets" => MsSubGrupAset::all()->where('status', 1),
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function filterSubGrupAset($id){
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $sub_grup_aset = MsSubGrupAset::all()->where('grup_aset', $id
            )->where('status', 1);
            // $sub_grup_aset = MsSubGrupAset::all()->where([
            //     'status'=> 1,
            //     'grup_aset' => $id, 
            // ]);

            foreach($sub_grup_aset as $sga){
                echo '<option value='.$sga->id.'>'.$sga->nama.'</option>';
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

            $kode = TbKeluhan::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "keluhan" => "required",
                "lokasi" => "required",
                "grup" => "required",
                "detail_lokasi" => "required",
            ]);

            // 0 - requested
            // 1 - responded
            // 2 - closed
            
            $create = TbKeluhan::create([
                "id" => $kode,
                "keluhan" => $validated['keluhan'],
                "lokasi" => $validated['lokasi'],
                "detail_lokasi" => $validated['detail_lokasi'],
                "grup" => $validated['grup'],
                "status" => 0,
                "pelapor" => Auth::user()->username,
            ]);
            
            $alert = '';
    
            if($create){
                $alert = 'success-add-keluhan';
            } else {
                $alert = 'danger-add-keluhan';
            }
            
            return redirect('/keluhan')->with('alert', $alert);
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function action(Request $request)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            
            // $request->validate([
            //     "id" => "",
            //     "konsumable[]"=>"required",
            //     "jumlah[]" => "required",
            // ]);

            $konsumables = $request->konsumable;
            $jumlahs = $request->jumlah;

            // dd($request);

            $create = "";

            if(!empty($konsumables) && !empty($jumlahs)){
                for($i=0; $i<count((array)$konsumables); $i++){

                    //insert data item out
                    $create = TbItemOut::create([
                        "id" => TbItemOut::idOtomatis(),
                        "konsumable" => $konsumables[$i],
                        "keluhan" => $request->keluhan,
                        "jumlah" => $jumlahs[$i],
                        "username" => Auth::user()->username 
                    ]);

                    $inventory = TbInventory::where('konsumable', $konsumables[$i])->orderBy('date_in', 'ASC')->get();

                    // dd($inventory);

                    $tempJumlah = $jumlahs[$i];

                    foreach($inventory as $inv){

                        if($tempJumlah != 0){
                            if($inv->jumlah_stock <= $tempJumlah){
                                $update = TbInventory::where('id', $inv->id)->update([
                                    "jumlah_stock" => 0
                                ]);
    
                                $tempJumlah = $tempJumlah - $inv->jumlah_stock ;
                            } else {
                                $update = TbInventory::where('id', $inv->id)->update([
                                    "jumlah_stock" => $inv->jumlah_stock - $tempJumlah
                                ]);
    
                                $tempJumlah = 0 ;
                            }
                        }
                    }

                }
            } else {
                $alert = 'warning-add-, item konsumable harus dipilih!';
                return back()->with('alert', $alert);
            }

            
            $alert = '';
    
            if($create){
                $alert = 'success-add-konsumable out';
            } else {
                $alert = 'danger-add-konsumable out';
            }
            
            return redirect('/keluhan-dashboard')->with('alert', $alert);
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
    public function close(Request $request)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $validated = $request->validate([
                "id" => "",
                "jenis_keluhan"=>"required",
                "solusi" => "required",
                "biaya" => "required",
                "kategori" => "required",
            ]);

            
            switch($validated['jenis_keluhan']){
                case 'Aset' :                           //jika jenis keluhan aset 
                    $validated = $request->validate([
                        "grup_aset"=>"required", //required grup aset
                        "sub_grup_aset" => "required", //required sub grup aset
                        "jenis_keluhan"=>"required",
                        "solusi" => "required",
                        "biaya" => "required",
                        "kategori" => "required",
                    ]);
                    $validated['non_aset'] = '';
                    break;
                case 'Non Aset' :                       //jika jenis keluhan non aset
                    $validated = $request->validate([ 
                        "non_aset"=>"required", //required non aset
                        "jenis_keluhan"=>"required",
                        "solusi" => "required",
                        "biaya" => "required",
                        "kategori" => "required",
                    ]);
                    $validated['grup_aset'] = '';
                    $validated['sub_grup_aset'] = '';
                    break;
            }
            
            // 0 - requested
            // 1 - responded
            // 2 - closed
            
            $update1 = TbResponKeluhan::where('keluhan', $request['keluhan'])->update([
                "solusi" => $validated['solusi'],
                "biaya" => $validated['biaya'],
                "kategori" => $validated['kategori'],
            ]);
            
            $update2 = TbKeluhan::where('id', $request['keluhan'])->update([
                "non_aset"=>$validated['non_aset'],
                "aset"=>$validated['sub_grup_aset'],
                "close_time" => Carbon::now(),
                "status" => 2,
            ]);
            
            $alert = '';
    
            if($update1 && $update2){
                $alert = 'success-add-respon keluhan dan close keluhan';
            } else {
                $alert = 'danger-add-respon keluhan dan close keluhan';
            }
    
            return redirect('/keluhan-dashboard')->with('alert', $alert);
            
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
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keluhan = VwKeluhan::findOrFail($id);
            $konsumables = VwItemOut::all()->where('keluhan', $id);
            $breadcrumb = [
                [
                    'nama' => "Keluhan",
                    'url' => "/keluhan"
                ],
                [
                    'nama' => "Lihat",
                    'url' => "/keluhan/".$id
                ],
            ];

            if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002") {
                $view = 'showAdmin';
            } else {
                $view = 'show';
            }
    
            return view('Qrgad/keluhan/'.$view, [
                "keluhan" => $keluhan ,
                "konsumables" => $konsumables ,
                "breadcrumbs" => $breadcrumb
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
    public function confirmResponse($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keluhan = VwKeluhan::findOrFail($id);
    
            return view('Qrgad/keluhan/confirmResponse', [
                "keluhan" => $keluhan
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
    public function editResponse($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $keluhan = VwKeluhan::findOrFail($id);
    
            return view('Qrgad/keluhan/editResponse', [
                "keluhan" => $keluhan
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        
    
    }
    public function response(Request $request, $id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $kode = TbResponKeluhan::idOtomatis();
            
            $create = TbResponKeluhan::create([
                "id" => $kode,
                "keluhan" => $id,
                "responden" => Auth::user()->username,
                "info_respon" => $request->note,
            ]);
            
            // 0 - requested
            // 1 - responded
            // 2 - closed

            $update = TbKeluhan::where('id', $id)->update([
                "respon_time" => Carbon::now(),
                "status" => 1,
            ]);
            

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }
    public function updateResponse(Request $request, $id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){
            
            $update = TbResponKeluhan::where('keluhan', $id)->update([
                "responden" => Auth::user()->username,
                "info_respon" => $request->note,
            ]);

            $update = TbKeluhan::where('id', $id)->update([
                "respon_time" => Carbon::now(),
            ]);
            

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
        //
    }
}
