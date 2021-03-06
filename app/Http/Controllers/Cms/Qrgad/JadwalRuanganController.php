<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Http\Controllers\Controller;
use App\Models\Table\Qrgad\MsPerusahaan;
use App\Models\Table\Qrgad\MsRuangan;
use App\Models\Table\Qrgad\MsToken;
use App\Models\View\Qrgad\VwJadwalRuangan;
use App\Models\Table\Qrgad\TbJadwalRuangan;
use App\Models\View\Qrgad\VwKeluhan;
use App\Models\View\Qrgad\VwTabelInventory;
use App\Models\View\Qrgad\VwTrip;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class JadwalRuanganController extends Controller
{

    public function __construct()
    {
        // hak akses : admin, super gad dan karyawan
        // $this->middleware(function ($request, $next) {
        //     if($this->permissionMenu('aplikasi-management') == 0) {
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

            $jadwal_arr = array();
            $jadwals =VwJadwalRuangan::all();
            $breadcrumb = [
                [
                    'nama' => "Jadwal Peminjaman Ruangan",
                    'url' => "/jadwal-ruangan"
                ]
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
    
            foreach ($jadwals as $jadwal){
                $jadwal_arr[] = [
                    'title' => " | ".$jadwal->agenda,
                    'start' => $jadwal->start,
                    'end' => $jadwal->end,
                    'backgroundColor' => $jadwal->color,
                ];
            }

            return view('Qrgad/jadwal_ruangan/index', [
                'jadwals' => $jadwal_arr,
                'breadcrumbs' => $breadcrumb,
            ])->with('data', $data);

        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }

    public function getByDay(){

        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $date = $_GET['date'];
            $jadwals = VwJadwalRuangan::where('start', 'like', '%' . $date . '%')->orWhere('end', 'like', '%' . $date . '%')->get();
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
            
            return view('Qrgad/jadwal_ruangan/byDate', [
                'tanggal' => $date,
                'jadwals' => $jadwals,
                'isConflict' => false,
                'isValidTime' => true
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
    public function create(Request $request)
    {

        // if($this->permissionActionMenu('aplikasi-management')->r==1){
            
            $breadcrumb = [
                [
                    'nama' => "Jadwal Peminjaman Ruangan",
                    'url' => "/jadwal-ruangan"
                ],
                [
                    'nama' => "Tambah",
                    'url' => "/jadwal-ruangan/create"
                ],
            ];

            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
    
            return view('Qrgad/jadwal_ruangan/create', [
                'perusahaans' => MsPerusahaan::all(),
                'ruangans' => MsRuangan::where('status', 1)->orderBy('lantai', 'ASC')->get(),
                'tanggal' => $request->date,
                'breadcrumbs' => $breadcrumb
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

        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $validated = $request->validate([
                "agenda" => "required",
                "perusahaan" => "required",
                "ruangan" => "required",
                "tanggal" => "required",
                "start" => "required",
                "end" => "required"
            ]);
    
            $validated['perusahaan'] = $request->perusahaan;
            if($request->color == null || $request->color == ''){
                $validated['color'] = '#7771D2';
            } else {
                $validated['color'] = $request->color;
            }
            
    
            $req_start = $validated['start'];
            $req_end = $validated['end'];
    
            $start = date('Y-m-d H:i:s', strtotime($req_start));
            $end = date('Y-m-d H:i:s', strtotime($req_end));
    
            $ruangan = $validated['ruangan'];
    
            $jadwals = TbJadwalRuangan::all()->where("ruangan", $ruangan);
            $jadwalSelisih = array();
    
            $isValidTime = true;
            $isConflict = false;
    
    
            // cek apakah inputan jam benar (end harus lebih dari start)
            if( $end < $start){
                $isValidTime = false; //input jam salah
            } else {
                $isValidTime = true; //input jam benar
            }
    
            // cek apakah inputan jam berselisih dengan jadwal peminjaman ruangan lain
            foreach($jadwals as $j){
            
                if(
                    ($start >= $j->start && $start <= $j->end)  // start_input nya berada di antara start dan end yang sudah ada
                    || ($end >= $j->start and $end <= $j->end) // end_input nya berada di antara start dan end yang sudah ada
                    || ($start <= $j->start and $end >= $j->end) // start_input melebihi start yang ada dan end_input melebihi end yang ada
                    
                    ){
                        $isConflict = true;
                        $jadwal = VwJadwalRuangan::find($j->id);
                        array_push($jadwalSelisih, $jadwal);
                }
            }
    
            $kode = TbJadwalRuangan::idOtomatis();
            if($isValidTime && !$isConflict){

                $id = $kode;
                $create = TbJadwalRuangan::create([
                    "id" => $id,
                    "peminjam" => Auth::user()->username,
                    "agenda" => $validated['agenda'],
                    "perusahaan" => $validated['perusahaan'],
                    "ruangan" => $validated['ruangan'],
                    "start" => $start,
                    "end" => $end,
                    "color" => $validated['color']
                ]);

                if($create){
                    $token = MsToken::orderBy('created_at', 'DESC')->first();
                    $jadwal_ruangan = VwJadwalRuangan::where('id', $kode)->first();

                    if(date("Y-m-d",strtotime($jadwal_ruangan->start)) == date("Y-m-d",strtotime($jadwal_ruangan->end))){
                        $waktu = date("d M Y H:i",strtotime($jadwal_ruangan->start))." - ".date("H:i",strtotime($jadwal_ruangan->end));
                    }
                    else{
                        $waktu = date("d M Y H:i",strtotime($jadwal_ruangan->start))." - ".date("d M Y H:i",strtotime($jadwal_ruangan->end));
                    }

                    try {
                        $response = Http::withToken($token->token)->post('https://graph.facebook.com/v13.0/101439039293669/messages', [
                            "messaging_product"=> "whatsapp", 
                            "to"=> Auth::user()->whatsapp, 
                            "type"=> "template",
                            "template"=> [ 
                                "name"=> "test_jadwal_ruangan", 
                                "language"=> [ "code"=> "id" ],
                                "components" => [
                                    0 => [
                                        "type" => "body",
                                        "parameters" => [
                                            0 => [
                                                "type" => "text",
                                                "text" => $jadwal_ruangan->ruangan
                                            ],
                                            1 => [
                                                "type" => "text",
                                                "text" => $jadwal_ruangan->perusahaan
                                            ],
                                            2 => [
                                                "type" => "date_time",
                                                "date_time" => [
                                                    "fallback_value" => $waktu
                                                ] 
                                            ]
                                        ]
                                    ]
                
                                ]
                                
                            ]
                            
                        ]);

                    } catch (Exception $e){
                        // return redirect('/jadwal-ruangan')->with('alert', 'danger-sendwhatsapp-');
                    }
                    
                    return redirect('/jadwal-ruangan')->with('alert', 'success-add-jadwal ruangan');

                } else {
                    return redirect('/jadwal-ruangan')->with('alert', 'danger-add-jadwal ruangan');
                }
                
           } else {
                return back()->withInput($request->input())->with('errorDate', 'error date');
           }
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }

    }

    public function testWa(){

        // TWILIO

        // $response = Http::withBasicAuth("AC458589511822f57cc1d6b66f985ceeaa" , "0a53498123fb95a8e7d687561d885800")
        // ->asForm()->post("https://api.twilio.com/2010-04-01/Accounts/AC458589511822f57cc1d6b66f985ceeaa/Messages.json", [
        //     "To" => "whatsapp:+628972178381",
        //     "From" => "whatsapp:+14155238886",
        //     "Body" => Auth::user()->nama." Peminjaman ruangan telah berhasil"
        // ]);

        // return $response->throw()->json();

        // -------
        
        // WHATSAPP

        $token = MsToken::orderBy('created_at', 'DESC')->first();
        $no = Auth::user()->whatsapp;

        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'AccessToken' => 'key',
        //     'Authorization' => 'Bearer '.$token,
        // ];
        
        // $client = new Client([
        //     'header' => $headers
        // ]);
        
        // $response = $client->request('POST', 'https://graph.facebook.com/v13.0/101439039293669/messages', [
        //     [
        //         "messaging_product"=> "whatsapp", 
        //         "to"=> $no, 
        //         "type"=> "template", 
        //         "template"=> [ 
        //             "name"=> "jadwal_ruangan_confirm", 
        //             "language"=> [ "code"=> "id" ]
        //         ] 
        //     ]
        // ]);


        $json = '{
            "messaging_product"=> "whatsapp", 
            "to"=> "6281389414947", 
            "type": "template",
            "template": {
                  "name": "jadwal_ruangan_confirm",
                  "language": {
                      "code": "id",
                  },
                  "components": [{
                      "type": "body",
                      "parameters": [
                          {
                              "type": "text",
                              "text": "Ruang 1"
                          },
                          {
                              "type": "text",
                              "text": "PT UTPE"
                          },
                          {
                              "type": "text",
                              "text": "Selasa, 8 Agustus 2022 10.00 - 13.00"
                          },
                          {
                              "type": "text",
                              "text": "http://localhost:8080/qrgad_dev/public/"
                          },
                      ]
                  }]
              }
          }';

          // template
        //   $response = Http::withToken($token->token)->post('https://graph.facebook.com/v13.0/101439039293669/messages', [
        //       "messaging_product"=> "whatsapp", 
        //       "to"=> "628972178381", 
        //       "type"=> "template", 
        //       "template"=> [ 
        //           "name"=> "jadwal_ruangan_confirm", 
        //           "language"=> [ "code"=> "id" ],
        //           "components" => [
        //               "type" => "body",
        //               "parameters" => [
        //                   0 => [
        //                       "type" => "text",
        //                       "text" => "Ruang Innovative 1"
        //                   ],
        //                   1 => [
        //                       "type" => "text",
        //                       "text" => "PT UTPE"
        //                   ],
        //                   2 => [
        //                       "type" => "text",
        //                       "text" => "Selasa, 8 Agustus 2022 10.00 - 13.00"
        //                   ],
        //                   3 => [
        //                       "type" => "url",
        //                       "text" => "http://localhost:8080/qrgad_dev/public/"
        //                   ],
        //               ]
        //           ]
        //       ] 
        //   ]);
          $response = Http::withToken($token->token)->post('https://graph.facebook.com/v13.0/101439039293669/messages', [
              "messaging_product"=> "whatsapp", 
              "to"=> "6281389414947", 
              "type"=> "template", 
              "template"=> [ 
                  "name"=> "test_jadwal_ruangan", 
                  "language"=> [ "code"=> "id" ],
                  "components" => [
                    0 => [
                        "type" => "body",
                        "parameters" => [
                            0 => [
                                "type" => "text",
                                "text" => "Ruang Innovative 1"
                            ],
                            1 => [
                                "type" => "text",
                                "text" => "PT UTPE"
                            ],
                            2 => [
                                "type" => "date_time",
                                "date_time" => [
                                    "fallback_value" => "2022-01-26 09:58:44"
                                ] 
                            ]
                        ]
                    ]

                  ]
                  
              ]
            
          ]);
        
        // message
        // $response = Http::withToken($token->token)->post('https://graph.facebook.com/v13.0/101439039293669/messages', [
        //     "messaging_product"=> "whatsapp", 
        //     "to"=> "628972178381", 
        //     "recipient_type" => "individual",
        //     "type"=> "text", 
        //     "text"=> [ 
        //         "preview_url"=> "false", 
        //         "body"=> "Peminjaman ruangan berhasil"
        //     ] 
        // ]);

        return $response;
        
        // -------
        
        

        // dd($client);

        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer '. $token,
        //     'Content-Type' => 'application/json'
        // ])->post('https://graph.facebook.com/v13.0/109548925100001/messages', [
        //     "messaging_product"=> "whatsapp", 
        //     "to"=> "628972178381", 
        //     "type"=> "template", 
        //     "template"=> [ 
        //         "name"=> "hello_world", 
        //         "language"=> [ "code"=> "en_US" ]
        //     ]
        // ]);

        // $sid    = "ACcebc7393626c9d66491b468c07601b75"; 
        // $token  = "[AuthToken]"; 
        // $twilio = new Client([
        //     "sid" => $sid, 
        //     "token" => $token
        // ]); 
        
        // $response = $twilio->messages 
        //                 ->create("whatsapp:+628972178381", // to 
        //                         array( 
        //                             "from" => "whatsapp:+14155238886",       
        //                             "body" => "Hello! This is an editable text message. You are free to change it and write whatever you like." 
        //                         ) 
        //                 ); 
        
        // print($response->sid);

        // $response = Http::withBasicAuth('ACcebc7393626c9d66491b468c07601b75', '[Redacted]' )->post('https://api.twilio.com/2010-04-01/Accounts/ACcebc7393626c9d66491b468c07601b75/Messages.json', [
        //     "from" => "whatsapp: 14155238886", 
        //     "to" => "whatsapp: 628972178381",      
        //     "body" => "Hello! This is an editable text message. You are free to change it and write whatever you like." 
        // ]);

        // return $response;
        // return Http::get('https://graph.facebook.com/v13.0/103151642415253/messages?messaging_product=whatsapp&to=628972178381&type=template&template%5Bname%5D=jadwal_ruangan_confirm&template%5Blanguage%5D%5Bcode%5D=id');
    }

    public function validateDate(){

        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $date = $_GET['date'];
            $room = $_GET['room'];
            $r_start = $_GET['start'];
            $r_end = $_GET['end'];
    
            $start = date('Y-m-d H:i:s', strtotime($r_start));
            $end = date('Y-m-d H:i:s', strtotime($r_end));
    
            $jadwals = TbJadwalRuangan::all()->where('ruangan', $room);
            $ruangan = MsRuangan::find($room);
            $jadwalSelisih = array();
    
            $isValidTime = false;
            $isConflict = false;
    
            // cek apakah inputan jam benar (end harus lebih dari start)
            if( $end < $start){
                $isValidTime = false; //input jam salah
            } else {
                $isValidTime = true; //input jam benar
            }
    
            // cek apakah inputan jam berselisih dengan jadwal peminjaman ruangan lain
            foreach($jadwals as $j){
              
                if(
                    ($start >= $j->start && $start <= $j->end)  // start_input nya berada di antara start dan end yang sudah ada
                    || ($end >= $j->start and $end <= $j->end) // end_input nya berada di antara start dan end yang sudah ada
                    || ($start <= $j->start and $end >= $j->end) // start_input melebihi start yang ada dan end_input melebihi end yang ada
                    
                    ){
                        $isConflict = true;
                        $jadwal = VwJadwalRuangan::find($j->id);
                        array_push($jadwalSelisih, $jadwal);
                }
            } 
    
            return view('Qrgad/jadwal_ruangan/byDate', [
                'tanggal' => $date,
                'ruangan' => $ruangan->nama,
                'jadwals' => $jadwalSelisih,
                'isConflict' => $isConflict,
                'isValidTime' => $isValidTime
            ]);
            
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

    public function history(){

        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $jadwals = VwJadwalRuangan::all()->where('username', Auth::user()->username);
            
            $breadcrumb = [
                [
                    'nama' => "Jadwal Peminjaman Ruangan",
                    'url' => "/jadwal-ruangan"
                ],
                [
                    'nama' => "Riwayat",
                    'url' => "/jadwal-ruangan-history"
                ],
            ];

            return view('Qrgad/jadwal_ruangan/history', [
                "jadwals" => $jadwals,
                "breadcrumbs" => $breadcrumb
            ]);
            
        // } else {
        //     return redirect("/")->with("error_msg", "Akses ditolak");
        // }
        
        
    }

    public function ticket($id){

        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $jadwal = VwJadwalRuangan::findOrFail($id);

            return view('Qrgad/jadwal_ruangan/ticket', [
                "jadwal" => $jadwal
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
