<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsKendaraan;
use App\Models\Table\Qrgad\MsSupir;
use App\Models\Table\Qrgad\TbTrip;
use App\Models\Table\Qrgad\TbTripHistori;
use App\Models\Table\Qrgad\TbTripRequest;
use App\Models\Table\Qrgad\TbTripVoucher;
use App\Models\Table\Qrgad\User;
use App\Models\View\Qrgad\VwTrip;
use App\Models\View\Qrgad\VwTripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TripController extends Controller
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
            if($level != "LV00000001" && $level != "LV00000002" && $level != "LV00000003" && $level != "LV00000004") {
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

            $breadcrumb = [
                'menu' => "TMS"
            ];
            
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return view('Qrgad/trip/index' , [
                "breadcrumbs" => $breadcrumb,
            ])->with('data', $data);


        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function schedule()
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $breadcrumb = [
                'menu' => "TMS",
                'sub-menu' => "Jadwal"
            ];
            
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return view('Qrgad/trip/schedule' , [
                "breadcrumbs" => $breadcrumb,
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function read(Request $request)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){
            

            if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002"){

                $trip_request = VwTrip::orderBy('id_trip_request', 'DESC')->get();
                $view = "readAdmin";

            } else {

                $trip_request = VwTrip::all()->where('username', Auth::user()->username);
                $view = "read";

            }

            if($request->awal != '' && $request->akhir != ''){
                $trip_request = $trip_request->whereBetween('waktu_berangkat',[$request->awal,$request->akhir])->whereBetween('waktu_pulang',[$request->awal,$request->akhir]);
            } 
            
            return view('Qrgad/trip/'.$view , [
                "trip_request" => $trip_request,
            ]);


        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function readSchedule(Request $request)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){  

            $trip = VwTrip::where('status', 3 ,)->whereNotNull('kendaraan')->orderBy('departure_time', 'DESC')->get();

            if($request->awal != '' && $request->akhir != ''){
                $trip = $trip->whereBetween('waktu_berangkat',[$request->awal,$request->akhir])->orWhereBetween('waktu_berangkat_aktual',[$request->awal,$request->akhir])->get();
            }
            
            return view('Qrgad/trip/readSchedule' , [
                "trip" => $trip,
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function tripFilter(Request $request)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){
            
            $trip = VwTrip::all()->whereNotNull('id_trip')->whereNotNull('set_trip_time')
            ->whereNotNull('kendaraan');
            
            if($request->awal != '' && $request->akhir != ''){
                $trip = $trip->whereBetween('waktu_berangkat',[$request->awal,$request->akhir])
                ->whereBetween('waktu_pulang',[$request->awal,$request->akhir]);
            } 

            foreach($trip as $t){
                echo "<option value=".$t->id_trip.">".$t->id_trip." | ".$t->kendaraan." | ".$t->nopol."</option>";
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
                "menu" => "Perjalanan",
                "sub-menu" => "Request Kendaraan"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/trip/formTms', [
                "tanggal" => Carbon::now(),
                "penumpangs" => User::all(),
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function pickCar($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $breadcrumb = [
                "menu" => "TMS",
                "sub-menu" => "Pilih Kendaraan"
            ];

            //status
            // 0 - rejected
            // 1 - Waiting Head
            // 2 - Waiting GAD
            // 3 - Responded
            // 4 - Closed

            $kendaraan = MsKendaraan::all()->where('status', 1);
            $date = Carbon::now();
            $trips = VwTrip::all()
            ->whereNotNull('id_trip') //yang telah dibuat tripnya
            ->whereNotIn("status", 4); //yang status tripnya belum closed
            // ->where('departure_time', '>=', Carbon::now()->format('Y-m-d')); //yang waktu keberangkatannya hari ini atau lebih

        

            foreach($kendaraan as $k){
                
                $i = 0;
                
                $k->setAttribute('booked', 0);

                foreach($trips as $t){
                    // dd($t->departure_time ."==". $date);
                    if($t->kendaraan_id == $k->id){
                        $i++;
                        $k->booked = $i;
                        // echo $k->id.'-'.$i.' ';
                    }

                    // echo $k->id.'-'.$i.' ';
                }
                // dd($kendaraan);
            }

            // dd($kendaraan);

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/trip/pickCar', [
                "trip" => VwTrip::where('id_trip_request', $id)->first(),
                "kendaraans" => $kendaraan,
                "supirs" => MsSupir::all()->where('status', 1),
                "breadcrumbs" => $breadcrumb
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }


    public function checkTrip()
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $breadcrumb = [
                "menu" => "TMS",
                "sub-menu" => "Check Trip"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/trip/checkTrip', [
                "breadcrumbs" => $breadcrumb,
                "tanggal" => Carbon::now(),
                "trips" => VwTrip::all()->whereNotNull('id_trip')->whereNotNull('set_trip_time')->whereNotNull('kendaraan'),
                "penumpangs" => User::all()
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function checkTripById($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $breadcrumb = [
                "menu" => "TMS",
                "sub-menu" => "Check Trip"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            $trip = VwTrip::where('id_trip', $id)->first();

            $pp = $trip->penumpang;
            $penumpang_plan = User::all()->whereIn('username', explode("," , $pp));

            $pa = $trip->penumpang_aktual;
            $penumpang_aktual = User::all()->whereIn('username', explode("," , $pa));
           
            return view('Qrgad/trip/checkTripById', [
                "breadcrumbs" => $breadcrumb,
                "tanggal" => Carbon::now(),
                "trips" => VwTrip::all()->whereNotNull('id_trip')->whereNotNull('set_trip_time')->whereNotNull('kendaraan'),
                "trip" => $trip,
                "penumpangs" => User::all(),
                "penumpangs_plan" => $penumpang_plan,
                "penumpangs_aktual" => $penumpang_aktual,
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function checkTripScan()
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){

            $breadcrumb = [
                "menu" => "TMS",
                "sub-menu" => "Check Trip"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/trip/scanner', [
                "breadcrumbs" => $breadcrumb,
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function checkTripIdTrip($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
           
            $trip = TbTrip::findOrFail($id);

            if ($trip != ''){
                $result = true;
            } else {
                $result = false;
            }

            return $result;

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

            // dd($request);

            $kode = TbTripRequest::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "jenis_perjalanan" => "required",
                "tujuan" => "required",
                "wilayah" => "required",
                "agenda" => "required",
            ]);

            if($request->jenis_perjalanan == 2){
                $validated = $request->validate([
                    "id" => "",
                    "jenis_perjalanan" => "required",
                    "tujuan" => "required",
                    "wilayah" => "required",
                    "agenda" => "required",
                    "waktu_berangkat" => "required",
                    "waktu_pulang" => "required",
                ]);

            } else {
                $validated = $request->validate([
                    "id" => "",
                    "jenis_perjalanan" => "required",
                    "tujuan" => "required",
                    "wilayah" => "required",
                    "agenda" => "required",
                    "waktu_berangkat" => "required",
                ]);

                $validated['waktu_pulang'] = null;
            }

            //jenis perjalanan
            // 1 - one way
            // 2 - round trip

            //status
            // 0 - rejected
            // 1 - Waiting Head
            // 2 - Waiting GAD
            // 3 - Responded
            // 4 - Closed
            
            $create = TbTripRequest::create([
                "id" => $kode,
                "jenis_perjalanan" => $validated['jenis_perjalanan'],
                "tujuan" => $validated['tujuan'],
                "wilayah" => $validated['wilayah'],
                "agenda" => $validated['agenda'],
                "kebutuhan" => $request->kebutuhan, 
                "penumpang" => $request->penumpang,
                "count_people" => count(explode(',', $request->penumpang)),
                "waktu_berangkat" => $validated['waktu_berangkat'],
                "waktu_pulang" => $validated['waktu_pulang'],
                "status" => 1,
                "input_time" => Carbon::now(),
                "pemohon" => Auth::user()->username,
                "departemen" => Auth::user()->departemen
            ]);
            
            $alert = '';
    
            if($create){
                $alert = 'success-add-peminjaman kendaraan';
            } else {
                $alert = 'danger-add-peminjaman kendaraan';
            }
    
            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return redirect('/trip')->with('data', $data);
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function checkOut(Request $request){
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            $kode = TbTripHistori::idOtomatis();
            $validated = $request->validate([
                "id" => "",
                "kilometer_berangkat" => "required",
                "waktu_berangkat" => "required",
            ]);

            $create = TbTripHistori::create([
                "id" => $kode,
                "trip" => $request->trip,
                "kilometer_berangkat" => $request->kilometer_berangkat,
                "waktu_berangkat" => $request->waktu_berangkat,
                "penumpang" => $request->penumpang
            ]);

            $alert = '';
    
            if($create){
                $alert = 'success-add-check out';
            } else {
                $alert = 'danger-add-check out';
            }
    
            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return redirect('/trip-schedule')->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function checkIn(Request $request){
        // if($this->permissionActionMenu('aplikasi-management')->c==1){
            
            $validated = $request->validate([
                "id" => "",
                "kilometer_pulang" => "required",
                "waktu_pulang" => "required",
            ]);

            $trip_histori = TbTripHistori::where('id', $request->trip_histori)->first();

            $updateTripHistory = $trip_histori->update([
                "kilometer_pulang" => $request->kilometer_pulang,
                "waktu_pulang" => $request->waktu_pulang,
                "kilometer_total" => $request->kilometer_pulang - $trip_histori->kilometer_berangkat,
            ]);

            $trip = VwTrip::where('id_trip_histori', $request->trip_histori)->first();
            $updateTripRequest = TbTripRequest::where('id', $trip->id_request)->update([
                "status" => 4
            ]);

            $alert = '';
    
            if($updateTripHistory && $updateTripRequest){
                $alert = 'success-add-check in';
            } else {
                $alert = 'danger-add-check in';
            }
    
            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return redirect('/trip-schedule')->with('data', $data);

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
            
            $breadcrumb = [
                "menu" => "TMS",
                "sub-menu" => "Detil Trip"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            $trip = VwTrip::where('id_trip_request', $id)->first();
            $voucher = TbTripVoucher::all()->where('trip', $trip->id_trip);

            $p =  $trip->penumpang;
            $penumpang = User::all()->whereIn('username', explode("," , $p));

            $pa =  $trip->penumpang_aktual;
            $penumpang_aktual = User::all()->whereIn('username', explode("," , $pa));

            if($trip->id_trip != ''){
                $qrcode = QrCode::size(200)->generate($trip->id_trip);
            } else {
                $qrcode = '';
            }
            
            return view('Qrgad/trip/showAdmin' , [
                "trip" => $trip,
                "vouchers" => $voucher,
                "penumpangs" => $penumpang,
                "penumpang_aktuals" => $penumpang_aktual,
                "breadcrumbs" => $breadcrumb,
                "qrcode" => $qrcode
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function showSchedule($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){           
            
            $breadcrumb = [
                "menu" => "TMS",
                "sub-menu" => "Detil Jadwal Trip"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            $trip = VwTrip::where('id_trip', $id)->first();

            $p = $trip->penumpang;
            $penumpang = User::all()->whereIn('username', explode("," , $p));
            
            $pa = $trip->penumpang_aktual;
            $penumpang_aktual = User::all()->whereIn('username', explode("," , $pa));
            
            return view('Qrgad/trip/showSchedule' , [
                "trip" => $trip,
                "penumpangs" => $penumpang,
                "penumpang_aktuals" => $penumpang_aktual,
                "breadcrumbs" => $breadcrumb,
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function ticket($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){           

            $breadcrumb = [
                "menu" => "TMS",
                "sub-menu" => "Ticket"
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            $trip = VwTrip::where('id_trip', $id)->first();
            $penumpang_trip = explode("," , $trip->penumpang);
            $penumpang = array();

            foreach($penumpang_trip as $p){
                array_push($penumpang, User::where('username', $p));
            }

            if($trip->id_trip != '' && $trip->kendaraan != ''){
                $qrcode = QrCode::size(200)->generate($trip->id_trip);
            } else {
                $qrcode = '';
            }
            
            return view('Qrgad/trip/ticket' , [
                "breadcrumbs" => $breadcrumb,
                "trip" => $trip,
                "penumpangs" => $penumpang,
                "qrcode" => $qrcode
            ])->with('data', $data);

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
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
           
            

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function confirmApprove($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
           
            $p = VwTrip::where('id_trip_request', $id)->first()->penumpang;
            $penumpang = User::all()->whereIn('username', explode("," , $p));

            return view('Qrgad/trip/confirmApprove', [
                "trip_request" => VwTrip::all()->where('id_trip_request', $id)->first(),
                "penumpangs" => $penumpang 
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    
    }

    public function confirmReject($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
           
            $p = VwTrip::where('id_trip_request', $id)->first()->penumpang;
            $penumpang = User::all()->whereIn('username', explode("," , $p));

            return view('Qrgad/trip/confirmReject', [
                "trip_request" => VwTrip::all()->where('id_trip_request', $id)->first(),
                "penumpangs" => $penumpang
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function confirmResponse($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
           
            $p = VwTrip::where('id_trip_request', $id)->first()->penumpang;
            $penumpang = User::all()->whereIn('username', explode("," , $p));

            return view('Qrgad/trip/confirmResponse', [
                "trip_request" => VwTrip::all()->where('id_trip_request', $id)->first(),
                "penumpangs" => $penumpang
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    
    }

    public function confirmSetTrip(Request $request, $id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){

            if($request->kendaraan != ''){
                $kendaraan = MsKendaraan::where('id', $request->kendaraan)->first();
                $trips = VwTrip::all()
                    ->whereNotNull('id_trip') //yang telah dibuat tripnya
                    ->whereNotIn('status', 4) //yang status tripnya belum closed
                    // ->where('departure_time', '>=', Carbon::now()->format('Y-m-d')) //yang waktu keberangkatannya hari ini atau lebih
                    ->where('kendaraan_id', $request->kendaraan); //yang kendaraannya seperti kendaraan yang dipilih

            } else {
                $kendaraan = '';
                $trips = '';
            }

            return view('Qrgad/trip/confirmSetTrip', [
                "trip" => VwTrip::where('id_trip', $id)->first(),
                "trips" => $trips,
                "supirs" => MsSupir::all()->where('status', 1),
                "kendaraan" => $kendaraan
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
            
            

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    
    }

    public function approve($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
            
            //status
            // 0 - rejected
            // 1 - Waiting Head
            // 2 - Waiting GAD
            // 3 - Responded
            // 4 - Closed

            $trip_request = TbTripRequest::where('id', $id)->update([
                "approve_time" => Carbon::now(),
                "approve_by" => Auth::user()->username,
                "status" => 2
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function reject(Request $request, $id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
            
            //status
            // 0 - rejected
            // 1 - Waiting Head
            // 2 - Waiting GAD
            // 3 - Responded
            // 4 - Closed

            $trip_request = TbTripRequest::where('id', $id)->update([
                "reject_time" => Carbon::now(),
                "reject_by" => Auth::user()->username,
                "keterangan" => $request->keterangan,
                "status" => 0
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function response($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
            
            //status
            // 0 - rejected
            // 1 - Waiting Head
            // 2 - Waiting GAD
            // 3 - Responded
            // 4 - Closed

            $id_trip = TbTrip::IdOtomatis();
            $trip = TbTrip::create([
                "id" => $id_trip,
                "trip_request" => $id
            ]);

            $trip_request = TbTripRequest::where('id', $id)->update([
                "response_time" => Carbon::now(),
                "status" => 3
            ]);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function setTrip(Request $request, $id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->u==1){
            
            //status
            // 0 - rejected
            // 1 - Waiting Head
            // 2 - Waiting GAD
            // 3 - Responded
            // 4 - Closed

            $trip = TbTrip::where('id', $id)->first();
            $trip_request_update = '';

            if($request->kendaraan != null){

                $trip_update = TbTrip::where('id', $id)->update([
                    "kendaraan" => $request->kendaraan,
                    "supir" => $request->supir,
                    "departure_time" => $request->departure_time
                ]);

            } else {

                //update departure time trip
                $trip_update = TbTrip::where('id', $id)->update([
                    "departure_time" => $request->departure_time
                ]);

                //create trip voucher 
                if($request->kode_voucher != ''){
                    foreach($request->kode_voucher as $k){
                        if($k != ''){
                            TbTripVoucher::create([
                                "id" => TbTripVoucher::idOtomatis(),
                                "trip" => $id,
                                "kode_voucher" => $k
                            ]);
                        }
                    }
                }

                //update trip request closed karena grab

                $trip_request_update = TbTripRequest::where('id', $trip->trip_request)->update([
                    "status" => 4,
                    "close_time" => Carbon::now()
                ]);
            }

            //update trip request set trip
            $update = TbTripRequest::where('id', $trip->trip_request)->update([
                "set_trip_time" => Carbon::now()
            ]);

            if($trip_update && $update){
                $alert = 'success-add-set perjalanan';
            } else {
                $alert = 'danger-add-set perjalanan';
            }

            $data = array(
                "alert" => $alert,
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            session()->flash('data', $data);

            return response()->json([
                'status'=>true,
                "redirect_url"=>url('/trip'),
                
            ]);

            // return redirect('/trip')->with('data', $data);

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
