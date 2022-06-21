<?php

namespace App\Http\Controllers\Cms\Qrgad;

use App\Exports\Qrgad\ExportAset;
use App\Http\Controllers\Controller;
use App\Imports\Qrgad\ImportAset;
use App\Models\Table\Qrgad\TbAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
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

    public function index()
    {
        
        // if($this->permissionActionMenu('aplikasi-management')->r==1){

            $aset = TbAset::all();
            $breadcrumb = [
                [
                    'nama' => "Aset",
                    'url' => "/aset"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );

            return view('Qrgad/asset/index', [
                "aset" => $aset,
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
                    'nama' => "Aset",
                    'url' => "/aset"
                ],
                [
                    'nama' => "Upload Aset",
                    'url' => "/aset/create"
                ],
            ];
            $data = array(
                // "actionmenu" => $this->permissionActionMenu('aplikasi-management')
            );
           
            return view('Qrgad/asset/create', [
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
        
    }

    public function import(Request $request){

        $this->validate($request,[
            'file' => "required",
        ]);

        TbAset::truncate();
        
        $file = $request->file('file');
        $namafile = $file->getClientOriginalName();
        $file->move('DataAset', $namafile);
        $import = Excel::import(new ImportAset, public_path('/DataAset/'.$namafile));

        $alert = '';

        if($import){
            $alert = 'success-add-asset';
        } else {
            $alert = 'danger-add-asset';
        }

        return redirect('/aset')->with('alert', $alert);
    }


    public function exportAset(Request $request){
        return Excel::download(new ExportAset, 'aset.xls');
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
