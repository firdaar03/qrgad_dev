<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsKendaraan;
use App\Models\Table\Qrgad\MsSupir;
use App\Models\Table\Qrgad\MsToken;
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
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Http;
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
            if($level != "LV00000001" && $level != "LV00000002" && $level != "LV00000003" && $level != "LV00000004" ) {
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

            $breadcrumb = [
                [
                    'nama' => "TMS",
                    'url' => "/trip"
                ],
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
                [
                    'nama' => "Jadwal TMS",
                    'url' => "/trip-schedule"
                ],
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

            $trip = VwTrip::where('status', 3 )->orWhere('status', 4 )->whereNotNull('kendaraan')->orderBy('departure_time', 'DESC')->get();

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
                [
                    'nama' => "TMS",
                    'url' => "/trip"
                ],
                [
                    'nama' => "Form TMS",
                    'url' => "/trip/create"
                ],
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/trip/formTms', [
                "tanggal" => Carbon::now(),
                "penumpangs" => User::where('level', 'LV00000002')->orwhere('level', 'LV00000004')->get(),
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
                [
                    'nama' => "TMS",
                    'url' => "/trip"
                ],
                [
                    'nama' => "Pilih Kendaraan",
                    'url' => "/trip-pick-car/".$id
                ],
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

            $trip = VwTrip::where('id_trip_request', $id)->first();
            $p =  $trip->penumpang;
            $penumpang = User::all()->whereIn('username', explode("," , $p));

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
                "trip" => $trip,
                "penumpang" => $penumpang,
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
                [
                    'nama' => "Jadwal TMS",
                    'url' => "/trip-schedule"
                ],
                [
                    'nama' => "Pilih Kendaraan",
                    'url' => "/trip-check"
                ],
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
                [
                    'nama' => "Jadwal TMS",
                    'url' => "/trip-schedule"
                ],
                [
                    'nama' => "Check Trip",
                    'url' => "/trip-check/".$id
                ],
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
                "penumpangs" => User::where('level', 'LV00000002')->orwhere('level', 'LV00000004')->get(),
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
                [
                    'nama' => "Jadwal TMS",
                    'url' => "/trip-schedule"
                ],
                [
                    'nama' => "Check Trip",
                    'url' => "/trip-check"
                ],
                [
                    'nama' => "Scan",
                    'url' => "/trip-check-scan"
                ],
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
           
            $trip = TbTrip::all()->where('id', $id)->first();

            if ($trip != '' && $trip != '[]'){
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

            if($request->jenis_perjalanan == 2){
                $validated = $request->validate([
                    "id" => "",
                    "keperluan" => "required",
                    "jenis_perjalanan" => "required",
                    "tujuan" => "required",
                    "wilayah" => "required",
                    "waktu_berangkat" => "required",
                    "waktu_pulang" => "required",
                ]);

            } else {
                $validated = $request->validate([
                    "id" => "",
                    "keperluan" => "required",
                    "jenis_perjalanan" => "required",
                    "tujuan" => "required",
                    "wilayah" => "required",
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
                "keperluan" => $validated['keperluan'],
                "jenis_perjalanan" => $validated['jenis_perjalanan'],
                "tujuan" => $validated['tujuan'],
                "wilayah" => $validated['wilayah'],
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
                $alert = 'success-add-permintaan kendaraan';
            } else {
                $alert = 'danger-add-permintaan kendaraan';
            }
    
            return redirect('/trip')->with('alert', $alert);
            
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
                $alert = 'success-add-check out kendaraan';
            } else {
                $alert = 'danger-add-check out kendaraan';
            }
            
            return redirect('/trip-schedule')->with('alert', $alert);

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

            //status
            // 0 - rejected
            // 1 - Waiting Head
            // 2 - Waiting GAD
            // 3 - Responded
            // 4 - Closed

            $trip_histori = TbTripHistori::where('id', $request->trip_histori)->first();

            $updateTripHistory = $trip_histori->update([
                "kilometer_pulang" => $request->kilometer_pulang,
                "waktu_pulang" => $request->waktu_pulang,
                "kilometer_total" => $request->kilometer_pulang - $trip_histori->kilometer_berangkat,
            ]);

            $trip = VwTrip::where('id_trip_histori', $request->trip_histori)->first();
            $updateTripRequest = TbTripRequest::where('id', $trip->id_trip_request)->update([
                "status" => 4
            ]);

            $alert = '';
    
            if($updateTripHistory && $updateTripRequest){
                $alert = 'success-add-check in kendaraan';
            } else {
                $alert = 'danger-add-check in kendaraan';
            }
            
            return redirect('/trip-schedule')->with('alert', $alert);

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
                [
                    'nama' => "TMS",
                    'url' => "/trip"
                ],
                [
                    'nama' => "Detail Trip",
                    'url' => "/trip/".$id
                ],
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

            $view = '';
            if(Auth::user()->level == 'LV00000001' || Auth::user()->level == 'LV00000002' ){
                $view = "showAdmin";
            } else {
                $view = "show";
            }
            
            return view('Qrgad/trip/'.$view , [
                "trip" => $trip,
                "vouchers" => $voucher,
                "penumpangs" => $penumpang,
                "penumpang_aktuals" => $penumpang_aktual,
                "breadcrumbs" => $breadcrumb,
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
    }

    public function showSchedule($id)
    {
        // if($this->permissionActionMenu('aplikasi-management')->r==1){           
            
            $breadcrumb = [
                [
                    'nama' => "Jadwal TMS",
                    'url' => "/trip-schedule"
                ],
                [
                    'nama' => "Detail",
                    'url' => "/trip-schedule/".$id
                ],
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
                [
                    'nama' => "TMS",
                    'url' => "/trip"
                ],
                [
                    'nama' => "Ticket",
                    'url' => "/trip-ticket/".$id
                ],
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
            // echo $request->kendaraan;

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

    public function sendWhatsappDriver($id){
        $token = MsToken::orderBy('created_at', 'DESC')->first();
        $trip = VwTrip::where('id_trip', $id)->first();

       try{
        
           $response = Http::withToken($token->token)->post('https://graph.facebook.com/v13.0/101439039293669/messages', [
               "messaging_product"=> "whatsapp", 
               "to"=> $trip->wa_supir, 
               "type"=> "template",
               "template"=> [ 
                   "name"=> "test_driver_trip_confirm", 
                   "language"=> [ "code"=> "id" ],
                   "components" => [
                       0 => [
                           "type" => "body",
                           "parameters" => [
                               0 => [
                                   "type" => "text",
                                   "text" => $trip->id_trip
                               ],
                               1 => [
                                   "type" => "text",
                                   "text" => $trip->supir
                               ],
                               2 => [
                                   "type" => "text",
                                   "text" => $trip->kendaraan
                               ],
                               3 => [
                                   "type" => "text",
                                   "text" => $trip->nopol
                               ],
                               4 => [
                                   "type" => "text",
                                   "text" => $trip->tujuan.", ".$trip->wilayah
                               ],
                               5 => [
                                   "type" => "date_time",
                                   "date_time" => [
                                       "fallback_value" => date('d M Y H:i', strtotime($trip->departure_time))
                                   ] 
                               ]
                           ]
                       ]
   
                   ]
                   
               ]
               
           ]);
       }catch(Exception $e){

       }

        return $response;
    }
    
    public function sendWhatsappPemohon($id){
        $token = MsToken::orderBy('created_at', 'DESC')->first();
        $trip = VwTrip::where('id_trip', $id)->first();
        $wa = $trip->wa_supir != ''? "+".$trip->wa_supir : "-";
       

        try{
            $response = Http::withToken($token->token)->post('https://graph.facebook.com/v13.0/101439039293669/messages', [
                "messaging_product"=> "whatsapp", 
                "to"=> $trip->wa_pemohon, 
                "type"=> "template",
                "template"=> [ 
                    "name"=> "test_employee_trip_confirm", 
                    "language"=> [ "code"=> "id" ],
                    "components" => [
                        0 => [
                            "type" => "body",
                            "parameters" => [
                                0 => [
                                    "type" => "text",
                                    "text" => $trip->id_trip
                                ],
                                1 => [
                                    "type" => "text",
                                    "text" => $trip->supir
                                ],
                                2 => [
                                    "type" => "text",
                                    "text" => $wa
                                ],
                                3 => [
                                    "type" => "text",
                                    "text" => $trip->kendaraan
                                ],
                                4 => [
                                    "type" => "text",
                                    "text" => $trip->nopol
                                ],
                                5 => [
                                    "type" => "date_time",
                                    "date_time" => [
                                        "fallback_value" => date('d M Y H:i', strtotime($trip->departure_time))
                                    ] 
                                ]
                            ]
                        ]
    
                    ]
                    
                ]
                
            ]);
        
        }catch(Exception $e){
 
        }

        return $response;
    }

    public function sendWhatsappPemohonGrab($id){
        $token = MsToken::orderBy('created_at', 'DESC')->first();
        $trip = VwTrip::where('id_trip', $id)->first();
        $trip_voucher = TbTripVoucher::all()->where('trip', $id);
        $voucher = '';
        foreach($trip_voucher as $t){
            if($trip_voucher->count() > 1){
                $voucher = $t->kode_voucher.", ".$voucher;
            } else {
                $voucher = $t->kode_voucher;
            }
        }

        // try{
            
            
        
        // }catch(Exception $e){

        // }

        $response = Http::withToken($token->token)->post('https://graph.facebook.com/v13.0/101439039293669/messages', [
            "messaging_product"=> "whatsapp", 
            "to"=> $trip->wa_pemohon, 
            "type"=> "template",
            "template"=> [ 
                "name"=> "test_employee_grab_trip_confirm", 
                "language"=> [ "code"=> "id" ],
                "components" => [
                    0 => [
                        "type" => "body",
                        "parameters" => [
                            0 => [
                                "type" => "text",
                                "text" => $trip->id_trip
                            ],
                            1 => [
                                "type" => "text",
                                "text" => "GRAB"
                            ],
                            2 => [
                                "type" => "date_time",
                                "date_time" => [
                                    "fallback_value" => date('Y-m-d H:i:s', strtotime($trip->departure_time))
                                ] 
                            ],
                            3 => [
                                "type" => "text",
                                "text" => $voucher
                            ]
                        ]
                    ]

                ]
                
            ]
            
        ]);

        return $response;
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

           
            if($trip_update != null){

                $trip_view = VwTrip::where('id_trip', $id)->first();

                if($request->kendaraan == null || $request->kendaraan == ''){
                    $this->sendWhatsappPemohonGrab($id);
                    
                } else {
                    
                    $this->sendWhatsappPemohon($id);
                    if($trip_view->wa_supir != null){
    
                        $this->sendWhatsappDriver($id);
                    }
                }


                session()->flash('alert', 'success-add-set trip');

                return response()->json([
                    'status'=>true,
                    "redirect_url"=>url('/trip'),
                    
                ]);

            } else {

                session()->flash('alert', 'danger-add-set trip');

                return response()->json([
                    'status'=>true,
                    "redirect_url"=>url('/trip'),
                    
                ]);
            }

            

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
