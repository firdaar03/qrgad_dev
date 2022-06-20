@extends('Qrgad/layout/qrgad-admin')

@section('content')
<div class="card shadow bg-info">
    <div class="d-flex justify-content-center mx-0">
        <div class="ticket card card-pricing bg-info w-auto" >
            <div class="ticket__wrapper">
            <div class="ticket__header" style="border-top: 0.5rem solid var(--azure)">
                <div class="mx-auto">
                    <div style="width: 200px">
                        <img src="{{ URL::asset('assets\Atlantis-Lite-master\img\patria.png') }} " alt="navbar brand" class="navbar-brand img-fluid">    
                    </div>
                    <div class="mt-3">
                        {!! $qrcode !!} 
                    </div>
                    
                </div>
            </div>
            </div>
            <div class="ticket__divider" style="border-bottom: 2px dashed var(--azure);">
                <div class="ticket__notch"></div>
                <div class="ticket__notch ticket__notch--right"></div>
            </div>
            <div class="ticket__body">
                <div class="card-header">
                    <h4 class="fw-bold">Perjalanan</h4>
                </div>
                <div class="card-body">
                    <ul class="specification-list">
                        <li>
                            <span class="name-specification fw-bold">ID Trip</span>
                            <span class="status-specification fw-light pl-5">{{ $trip->id_trip }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Tujuan</span>
                            <span class="status-specification fw-light pl-5">{{ $trip->tujuan.", ".$trip->wilayah }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Jenis Perjalanan</span>
                            <span class="status-specification fw-light pl-5">
                                @php 
                                    switch ($trip->jenis_perjalanan) {
                                        case 1:
                                            echo "One Way" ;
                                            break;
                                        case 2:
                                            echo "Round Trip" ;
                                            break;
                                    } 
                                @endphp
                            </span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Waktu Berangkat</span>
                            <span class="status-specification fw-light pl-5">{{ date("d M Y H:i",strtotime($trip->departure_time)) }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Waktu Pulang</span>
                            <span class="status-specification fw-light pl-5">{{ date("d M Y H:i",strtotime($trip->waktu_pulang)) }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Kendaraan</span>
                            <span class="status-specification fw-light pl-5">{{ $trip->kendaraan }}</span>
                        </li>
                        <li>
                            <span class="name-specification fw-bold">Supir</span>
                            <span class="status-specification fw-light pl-5">{{ $trip->supir }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="ticket__footer">
                @if ($trip->status == 4)
                    <span class="badge badge-success text-center">
                        <span class="mx-3">Selesai</span>
                    </span> 
                @else
                    <span class="badge badge-warning text-center">
                        <span class="mx-3">Aktif</span>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex float-right mt-5 mb-5">
        <div class="d-inline mr-2">
            <a href="{{ url('/trip') }}" class="btn btn-secondary float-right">Kembali</a>
        </div>
    </div>

</div>
    
@endsection