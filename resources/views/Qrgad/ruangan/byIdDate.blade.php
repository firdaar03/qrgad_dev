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

    @foreach ($list as $l)
        <div class="card shadow mt-3">
            <div class="d-flex align-items-center">
                <div class="my-auto ml-3">
                    <span class="stamp stamp-sm" style="background-color: {{ $l->color }}"></span>
                </div>
                <div class="container my-2">
                    <div class="row">
                        <div class="col">
                            <h5 class="fw-bold">
                                @if (date("Y-m-d",strtotime($l->start)) == $tanggal)
                                    {{ date("H:i",strtotime($l->start)) }}
                                @else
                                    {{ date("d M Y H:i",strtotime($l->start)) }}
                                @endif

                                <span class="fw-bold"> - </span>

                                @if (date("Y-m-d",strtotime($l->end)) == $tanggal)
                                    {{ date("H:i",strtotime($l->end)) }}
                                @else
                                    {{ date("d M Y H:i",strtotime($l->end)) }}
                                @endif
                            </h5>
                            
                            
                        </div>
                        <div class="col">
                            <h5 class="fw-bold">{{ $l->ruangan }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <span class="fw-small text-muted text-capitalize">{{ explode(" ", $l->peminjam)[0].' '.explode(" ", $l->peminjam)[1].' ('.$l->divisi.')'}} </span>
                        </div>
                        <div class="col">
                            <span class="fw-small text-muted">{{ ($l->perusahaan == '')? '-' : $l->perusahaan }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
   