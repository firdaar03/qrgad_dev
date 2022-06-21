<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\TbJadwalRuangan;
use App\Models\Table\Qrgad\User;
use App\Models\View\Qrgad\VwJadwalRuangan;
use App\Models\View\Qrgad\VwRuanganLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller
{
    public function __construct()
    {
        // hak akses : all
        // $this->middleware(function ($request, $next) {
        //     if($this->permissionMenu('aplikasi-management') == 0) {
        //         return redirect("/")->with("error_msg", "Akses ditolak");
        //     }
        //     return $next($request);
        // });

    }

    public function index(){
        $breadcrumb = [
            [
                'nama' => "Dashboard",
                'url' => "/dashboard"
            ],
        ];

        // resources\file\emp.json
        



        $new_emp = file_get_contents('resources/file/data_emp.json');



        if(Auth::user()->whatsapp == '' || Auth::user()->whatsapp == null){

            return view("Qrgad/dashboard/dashboard", [
                "breadcrumbs" => $breadcrumb
            ]);
        } else {
            return view("Qrgad/dashboard/dashboard", [
                "breadcrumbs" => $breadcrumb
            ]);
        }
    }

    public function admin(){
        $breadcrumb = [
            [
                'nama' => "Dashboard",
                'url' => "/dashboard"
            ],
        ];

        // $old_emp = json_decode(file_get_contents(URL::asset('resources/file/emp.json')));
        // $arr_emp = array();

        // foreach($old_emp as $oe){
        //     $oe = array("password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
        //     $oe = array("level" => 'LV00000004');

        //     array_push($arr_emp, $oe);
        // }

        // dd($arr_emp);

        $data = array(
            // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
        );

        $user = User::all()->where('username', Auth::user()->username);
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


        if(Auth::user()->whatsapp == '' || Auth::user()->whatsapp == null){
            return view("Qrgad/dashboard/dashboard", [
                "ruangan" => $ruangan,
                "jadwal" => $jadwal,
                "breadcrumbs" => $breadcrumb,
                "addWhatsapp" => 'true',
                "user" => $user,
            ])->with('data', $data);
        } else {
            return view("Qrgad/dashboard/dashboard", [
                "ruangan" => $ruangan,
                "jadwal" => $jadwal,
                "breadcrumbs" => $breadcrumb,
                "addWhatsapp" => 'false',
            ])->with('data', $data);
        }
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
