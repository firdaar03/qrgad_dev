<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\DtRuangan;
use App\Models\Table\Qrgad\MsFasilitasRuangan;
use App\Models\Table\Qrgad\MsLokasi;
use App\Models\Table\Qrgad\MsRuangan;
use App\Models\Table\Qrgad\TbJadwalRuangan;
use App\Models\View\Qrgad\VwJadwalRuangan;
use App\Models\View\Qrgad\VwRuanganLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
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

            $ruangan = VwRuanganLokasi::all();
            $breadcrumb = [
                [
                    'nama' => "Ruangan",
                    'url' => "/ruangan"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/ruangan/index', [
                "ruangan" => $ruangan,
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
                    'nama' => "Ruangan",
                    'url' => "/ruangan"
                ],
                [
                    'nama' => "Tambah",
                    'url' => "/ruangan/create"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/ruangan/create', [
                "fasilitas" => MsFasilitasRuangan::all()->where('status', 1),
                "lokasi" => MsLokasi::all()->where('status', 1),
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

            $kode = MsRuangan::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "nama" => "required|unique:ms_ruangans",
                "lantai" =>"required",
                "kapasitas" => "required",
                "lokasi" => "required"
            ]);
    
            $create = MsRuangan::create([
                "id" => $kode,
                "nama" => $validated['nama'],
                "lantai" => $validated['lantai'],
                "kapasitas" => $validated['kapasitas'],
                "lokasi" => $validated['lokasi'],
                "status" => 1,
                "created_by" => Auth::user()->nama,
            ]);
           
            $idfasilitas = $request->idf;
            $jumlah = $request->jumlah;
            if(!empty($jumlah)){
                for($i=0; $i<count((array)$jumlah); $i++ ){
                    if($jumlah[$i] != 0){
                        DtRuangan::create([
                            'fasilitas' => $idfasilitas[$i],
                            'ruangan' => $kode,
                            'jumlah' => $jumlah[$i],
                        ]);
                    }
                }
            }
    
            $alert = '';

            if($create){
                $alert = 'success-add-ruangan';
            } else {
                $alert = 'danger-add-ruangan';
            }

            return redirect('/ruangan')->with('alert', $alert);

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
    public function show(MsRuangan $ruangan)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $fasilitas = MsFasilitasRuangan::all()->where('status', 1);
            $lokasi = MsLokasi::all()->where('status', 1);
            $dtruang = DtRuangan::all()->where("ruangan", $ruangan->id);
            $breadcrumb = [
                [
                    'nama' => "Ruangan",
                    'url' => "/ruangan"
                ],
                [
                    'nama' => "Lihat",
                    'url' => "/ruangan/".$ruangan->id
                ],
            ];
    
            return view('Qrgad/ruangan/show', [
                "r" => $ruangan,
                "fasilitas" => $fasilitas ,
                "lokasi" => $lokasi,
                "dtruang" => $dtruang,
                "breadcrumbs" => $breadcrumb
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
    public function edit(MsRuangan $ruangan)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
            
            $fasilitas = MsFasilitasRuangan::all()->where('status', 1);
            $lokasi = MsLokasi::all()->where('status', 1);
            $dtruang = DtRuangan::all()->where("ruangan", $ruangan->id);
            $breadcrumb = [
                [
                    'nama' => "Ruangan",
                    'url' => "/ruangan"
                ],
                [
                    'nama' => "Edit",
                    'url' => "/ruangan/".$ruangan->id."/edit"
                ],
            ];
    
            return view('Qrgad/ruangan/edit', [
                "r" => $ruangan,
                "fasilitas" => $fasilitas ,
                "lokasi" => $lokasi,
                "dtruang" => $dtruang,
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
    public function update(Request $request, MsRuangan $ruangan)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){

            $validated = $request->validate([
                "id" => "",
                "nama" => "required|min:5",
                "lantai" =>"required",
                "kapasitas" => "required",
                "lokasi" => "required"
            ]);
    
            $create = MsRuangan::where('id', $ruangan->id)->update([
                "nama" => $validated['nama'],
                "lantai" => $validated['lantai'],
                "kapasitas" => $validated['kapasitas'],
                "lokasi" => $validated['lokasi'],
                "updated_by" => Auth::user()->nama,
            ]);
    
            DtRuangan::where('ruangan', $ruangan->id)->delete();
    
            $idfasilitas = $request->idf;
            $jumlah = $request->jumlah;
            if(!empty($jumlah)){
                for($i=0; $i<count((array)$jumlah); $i++ ){
                    if($jumlah[$i] != 0){
                        DtRuangan::create([
                            'fasilitas' => $idfasilitas[$i],
                            'ruangan' => $ruangan->id,
                            'jumlah' => $jumlah[$i],
                        ]);
                    }
                }
            }

            $alert = '';
            if($create){
                $alert = 'success-edit-ruangan';
            } else {
                $alert = 'danger-edit-ruangan';
            }
    
            return redirect('/ruangan')->with('alert', $alert);

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
            
            $update = MsRuangan::where('id', $id)->update([
                "status" => 0
            ]);

            $alert = '';

            if($update){
                $alert = 'success-delete-ruangan';
            } else {
                $alert = 'danger-delete-ruangan';
            }

            return redirect('/ruangan')->with('alert', $alert);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }

    public function report()
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){
            $breadcrumb = [
                [
                    'nama' => "Report Ruangan",
                    'url' => "/ruangan-report"
                ],
            ];

            $ruangan = VwRuanganLokasi::all();
            $start = date("Y-m-d",time()). ' 00:00:00';
            $end = date("Y-m-d",time()). ' 23:59:59';

            foreach($ruangan as $r){
                $jadwal = TbJadwalRuangan::all()->where('ruangan', $r->id_ruang);
                foreach($jadwal as $j){
                    if($j->start >= $start && $j->end <= $end){
                        $r->setAttribute('available', 1);
                    } else{
                        $r->setAttribute('available', 0);
                    }
                }
            }
  
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/ruangan/report', [
                "ruangan" => $ruangan,
                "jadwal" => $jadwal,
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function getByDay($id){

        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $start = date("Y-m-d",time()). ' 00:00:00';
            $end = date("Y-m-d",time()). ' 23:59:59';
            $list = VwJadwalRuangan::where('id_ruangan', '=', $id)->where('start', '>=', $start)->where('end', '<=', $end)->get();

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return view('Qrgad/ruangan/byIdDate', [
                'id' => $id,
                'tanggal' => date("Y-m-d",time()),
                'list' => $list,
            ])->with('data', $data);
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }
}
