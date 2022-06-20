<div class="modal-header">
    <h5 class="modal-title">
        Jadwal Peminjaman Ruangan 
        <div class="fw-bold mt-2">
            {{ setlocale(LC_ALL, 'id_ID') }}
            {{ strftime("%A, %d %B %Y", strtotime($tanggal)); }}
        </div>
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<div class="modal-body">
    {{-- {{ "is conflict ".strval($isConflict)." is work hour ".strval($isWorkHour) }} --}}
    @if (!$isValidTime || $isConflict)
        <div class="card card-stats card-danger card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-1 align-items-center">
                        <i class="far fa-times-circle fa-2x"></i>
                    </div>
                    <div class="col">

                        @if(!$isValidTime && $isConflict)
                            <ul>
                                <li>
                                    <span>Waktu peminjaman yang anda inputkan tidak sesuai, silahkan periksa kembali am/pm jam.</span>
                                </li>
                                <br>
                                <li>
                                    <span>Waktu peminjaman yang anda inputkan berselisih dengan jadwal peminjaman lain untuk ruangan <strong>{{ $ruangan }}</strong>, silahkan pilih ulang jam atau ruangan. Berikut adalah daftar jadwal yang berselisih : </span> 
                                </li>
                            </ul>
                        @elseif (!$isValidTime)
                            <span>Waktu peminjaman yang anda inputkan tidak sesuai, silahkan periksa kembali am/pm jam.</span>
                        @elseif($isConflict)    
                            <span>Waktu peminjaman yang anda inputkan berselisih dengan jadwal peminjaman lain untuk ruangan <strong>{{ $ruangan }}</strong>, silahkan pilih ulang jam atau ruangan. Berikut adalah daftar jadwal yang berselisih : </span> 
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @elseif($jadwals == null)
        <span class="text-muted">Belum ada jadwal</span>
    @endif

    @foreach ($jadwals as $jadwal)
        {{-- <p>{{ $jadwal->agenda }}</p> --}}
        <div class="card shadow mt-3">
            <div class="d-flex align-items-center">
                <div class="my-auto ml-3">
                    <span class="stamp stamp-sm" style="background-color: {{ $jadwal->color }}"></span>
                </div>
                <div class="container my-2">
                    <div class="row">
                        <div class="col">
                            <h5 class="fw-bold">
                               
                                @if (date("Y-m-d",strtotime($jadwal->start)) == $tanggal)
                                    {{ date("H:i",strtotime($jadwal->start)) }}
                                @else
                                    {{ date("d M Y H:i",strtotime($jadwal->start)) }}
                                @endif

                                <span class="fw-bold"> - </span>

                                @if (date("Y-m-d",strtotime($jadwal->end)) == $tanggal)
                                    {{ date("H:i",strtotime($jadwal->end)) }}
                                @else
                                    {{ date("d M Y H:i",strtotime($jadwal->end)) }}
                                @endif
                                {{-- d M Y H:i --}}
                                {{-- {{ date("H:i",strtotime($jadwal->start)) }} - {{ date("H:i",strtotime($jadwal->end)) }} --}}
                            </h5>
                            
                            
                        </div>
                        <div class="col">
                            <h5 class="fw-bold">{{ $jadwal->ruangan }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @php
                                $user = explode(" ", $jadwal->peminjam);;
                                if(count($user) < 2){
                                    $peminjam = $user[0];
                                } else {
                                    $peminjam = $user[0]." ".$user[1];
                                }
                            @endphp 
                           
                            <span class="fw-small text-muted text-capitalize">{{ $peminjam }} </span>
                        </div>
                        <div class="col">
                            <span class="fw-small text-muted">{{ ($jadwal->perusahaan == '')? '-' : $jadwal->perusahaan }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
   
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    @if ($isValidTime && !$isConflict)
        <a href="{{ url('/jadwal-ruangan/create') }}?date={{ $tanggal }}" type="button" class="btn btn-primary" onclick="">Tambah hari ini</a>
    @endif
  </div>
</div>