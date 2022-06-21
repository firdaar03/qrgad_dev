<div class="modal-header">
    <h5 class="modal-title">
        Peminjaman Ruangan Saya 
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body bg-primary">
    <div class="d-flex justify-content-center mx-0">
        <div class="ticket card card-pricing bg-primary w-auto">
            <div class="ticket__wrapper">
              <div class="ticket__header" style="border-top: 0.5rem solid {{ $jadwal->color }}">
                <div class="d-flex centered mx-5">
                    <img src="{{ URL::asset('assets\Atlantis-Lite-master\img\patria.png') }} " alt="navbar brand" class="navbar-brand img-fluid">
                </div>
              </div>
            </div>
            <div class="ticket__divider" style="border-bottom: 2px dashed {{ $jadwal->color }};">
                <div class="ticket__notch"></div>
                <div class="ticket__notch ticket__notch--right"></div>
            </div>
            <div class="ticket__body">
                <div class="card-header">
                    <h4 class="fw-bold">Meeting Room</h4>
                </div>
                <div class="card-body">
                    <ul class="specification-list">
                        <li>
                            <span class="name-specification fw-bold">Agenda</span>
                            <span class="status-specification fw-light pl-5">{{ $jadwal->agenda }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Perusahaan</span>
                            <span class="status-specification fw-light pl-5">{{ ($jadwal->perusahaan == '')? '-' : $jadwal->perusahaan }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Ruangan</span>
                            <span class="status-specification fw-light pl-5">{{ $jadwal->ruangan }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Mulai</span>
                            <span class="status-specification fw-light pl-5">{{ date("d M Y H:i",strtotime($jadwal->start)) }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Sampai</span>
                            <span class="status-specification fw-light pl-5">{{ date("d M Y H:i",strtotime($jadwal->end)) }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Peminjam</span>
                            <span class="status-specification fw-light pl-5">{{ $jadwal->peminjam }}</span>
                        </li>
    
                    </ul>
                </div>
            </div>
            <div class="ticket__footer">
                @if ($jadwal->end < date('Y-m-d H:i:s')) 
                    <span class="badge badge-secondary text-center">
                        <span class="mx-3">Tidak Aktif</span>
                    </span>
                @else
                    <span class="badge badge-success text-center">
                        <span class="mx-3">Aktif</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>