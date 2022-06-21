<li class="nav-item dropdown hidden-caret">
    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-bell"></i>
      <span class="notification bg-danger">{{ count($notif_keluhan) + count($notif_trip) + count($notif_inventory)}}</span>
    </a>
    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
      <li>
        <div class="notif-scroll scrollbar-outer">
            <div class="notif-center">
                
                {{-- notif keluhan --}}
                @if ($notif_keluhan != [] && $notif_keluhan != '[]')

                    <hr>
                        <span class="container block notif-content">Laporan Keluhan ( {{ count($notif_keluhan) }} )</span>
                    <hr>

                    @foreach ($notif_keluhan as $n)
                        <a href="
                            {{-- jika admin/GAD --}}
                            @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")    
                                {{ url('/keluhan-dashboard') }}
                            {{-- jika karyawan --}}
                            @elseif(Auth::user()->level == "LV00000004")
                                {{ url('/keluhan/'.$n->id) }} 
                            @endif
                        ">
                            <div class="notif-icon {{ $n->status == 0? 'notif-danger' : 'notif-warning' }}"> <i class="fa fa-flag"></i> </div>
                            <div class="notif-content">
                                {{-- jika admin/GAD --}}
                                @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                                    <span class="block">
                                        {{ count(explode(" ", $n->pelapor)) > 1? explode(" ", $n->pelapor)[0] : $n->pelapor }} melaporkan keluhan 
                                    </span>
                                    <span class="block">
                                        {{ '('.$n->keluhan.')' }}
                                    </span>
                                {{-- jika karyawan --}}
                                @elseif(Auth::user()->level == "LV00000004")
                                    <span class="block">
                                        {{ 'Keluhan telah direspon'  }}
                                    </span>
                                    <span class="block">
                                        {{ '('.$n->info_respon.')'  }}
                                    </span>
                                @endif
                                {{-- jika admin/GAD --}}
                                @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                                
                                    <span class="time">{{ \Carbon\Carbon::parse($n->input_time)->diffForHumans() }}</span> 
                                {{-- jika karyawan --}}
                                @elseif(Auth::user()->level == "LV00000004")
                                    
                                    <span class="time">{{ \Carbon\Carbon::parse($n->respon_time)->diffForHumans() }}</span> 

                                @endif
                            </div>
                        </a>
                    @endforeach
                @endif

                {{-- notif trip --}}
                @if ($notif_trip != [] && $notif_trip != '[]')

                    <hr>
                        <span class="container block notif-content">Peminjaman Kendaraan ( {{ count($notif_trip) }} )</span>
                    <hr>

                    @foreach ($notif_trip as $n)
                    <a href="
                        {{-- jika admin/GAD --}}
                        @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")    
                            {{ url('/trip') }}
                        {{-- jika karyawan --}}
                        @elseif(Auth::user()->level == "LV00000004")
                            {{ url('/trip/'.$n->id_trip_request) }} 
                        @endif
                    ">
                        <div 
                            class="@switch($n->status)
                            @case(0)
                                {{ "notif-icon notif-danger" }}
                                @break
                            @case(1)
                                {{ "notif-icon notif-secondary" }}
                                @break
                            @case(2)
                                {{ "notif-icon notif-primary" }}
                                @break
                            @case(3)
                                {{ "notif-icon notif-warning" }}
                                @break
                        @endswitch"
                            
                        > <i class="fa fa-car"></i> </div>
                        <div class="notif-content">
                        <span class="block">
                            {{-- jika admin/GAD --}}
                            @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                                
                                {{ count(explode(" ", $n->pemohon)) > 1? explode(" ", $n->pemohon)[0] : $n->pemohon }}
                                @switch($n->status)
                                    @case(1)
                                        {{ 'menunggu approval Head' }}
                                        @break
                                    @case(2)
                                        {{ 'menuggu response GAD'}}
                                        @break
                                    @case(3)
                                        {{ 'menunggu pemilihan kendaraan'}}
                                        @break
                                @endswitch

                            {{-- jika karyawan --}}
                            @elseif(Auth::user()->level == "LV00000004")
                                
                                {{ ' ' }}
                                @switch($n->status)
                                    @case(0)
                                        {{ 'Trip Request di-reject' }}
                                        @break
                                    @case(2)
                                        {{ 'Trip Request telah di-approve Head'}}
                                        @break
                                    @case(3)
                                        {{-- jika sudah set trip --}}
                                        @if ($n->set_trip_time != '')
                                            {{ 'Trip telah diatur' }}
                                        @else
                                            {{ 'Trip request telah di-response GAD' }}
                                        @endif
                                        @break
                                @endswitch

                            @endif
                            
                        </span>
                        <span class="time">
                            @switch($n->status)
                                @case(0)
                                    {{ \Carbon\Carbon::parse($n->reject_time)->diffForHumans() }}
                                    @break
                                @case(1)
                                    {{ \Carbon\Carbon::parse($n->input_time)->diffForHumans() }}
                                    @break
                                @case(2)
                                    {{ \Carbon\Carbon::parse($n->approve_time)->diffForHumans() }}
                                    @break
                                @case(3)
                                    {{-- jika sudah set trip --}}
                                    @if ($n->set_trip_time != '')
                                        {{ \Carbon\Carbon::parse($n->set_trip_time)->diffForHumans() }}
                                    @else
                                        {{ \Carbon\Carbon::parse($n->response_time)->diffForHumans() }}
                                    @endif
                                    @break
                            @endswitch
                            </span> 
                        </div>
                    </a>
                    @endforeach
                @endif

                
                {{-- notif inventory --}}
                @if ($notif_inventory != [] && $notif_inventory != '[]')

                    <hr>
                        <span class="container block notif-content">Inventory stok limit ( {{ count($notif_inventory ) }} )</span>
                    <hr>

                    @foreach ($notif_inventory as $n)
                    <a href="{{ url('/inventory-tambah/'.$n->id_konsumable) }}">
                        <div class="notif-icon notif-danger"> <i class="fa fa-cubes"></i> </div>
                        <div class="notif-content">
                            <span class="block">
                                {{ $n->nama_konsumable }} dalam limit stock ( {{ $n->stock }} )
                            </span>
                            <span class="time">{{ \Carbon\Carbon::parse($n->last_out)->diffForHumans() }}</span> 
                        </div>
                    </a>
                    @endforeach
                @endif

            </div>
        </div>
      </li>
      
    </ul>
</li>