
@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header d-flex flex-inline">
				<div class="col">
					<h3><b>Detail Keluhan</b></h3>
				</div>
            </div>
            <div class="card-body">
				<ol class="activity-feed">

					{{-- status --}}
					{{-- 0 - rejected --}}
					{{-- 1 - Waiting Head --}}
					{{-- 2 - Waiting GAD --}}
					{{-- 3 - Responded --}}
					{{-- 4 - Closed --}}

					{{-- Rejected --}}
					@if ($trip->status == 0)
						<li class="feed-item feed-item-danger">
							<time class="date fw-bold">
								{{ date("d M Y H:i",strtotime($trip->reject_time)) }} 
								<div class="badge badge-danger ml-2">
									<span class="fw-bold">Rejected</span>
								</div>
							</time>
							<span class="text">
								Request kendaraan telah di-reject oleh 
								<span class="fw-bold">{{ $trip->reject_by }}</span> dengan catatan seperti berikut : 
								<br><br>
								<span>
									{{ $trip->keterangan }}
								</span>
							</span>
						</li>
					@endif

					{{-- Closed --}}
					@if ($trip->status >= 4)
						<li class="feed-item feed-item-success">
							<time class="date fw-bold">
								{{ date("d M Y H:i",strtotime($trip->close_time)) }} 
								<div class="badge badge-success ml-2">
									<span class="fw-bold">Closed</span>
								</div>
							</time>
							<span class="text">
								Perjalanan telah selesai 
								
								@if ($trip->id_trip_histori != '')
									dengan detil seperti berikut :  
									<div class="row py-1 container">
										<div class="col-md-3 d-flex flex-column justify-content-around">
											<br>
											<div>
												<h4 class="fw-bold">Jauh Perjalanan</h4>
												<span>{{ $trip->kilometer_total }} km</span>
											</div>
											<br>
											<div>
												<h4 class="fw-bold">Penumpang Aktual</h4>
												@foreach ($penumpang_aktuals as $p)
													<span>{{ $p->nama }}</span><br>
												@endforeach
											</div>
											<br>
										</div>
										<div class="col-md-3 d-flex flex-column justify-content-around">
											<br>
											<div>
												<h4 class="fw-bold">Berangkat Aktual</h4>
												<span>{{ date("d M Y H:i",strtotime($trip->waktu_berangkat_aktual)) }}</span>
											</div>
											<br>
											<div>
												<h4 class="fw-bold">Pulang Aktual</h4>
												<span>{{ date("d M Y H:i",strtotime($trip->waktu_pulang_aktual)) }}</span>
											</div>
											<br>
										</div>
									</div>
								@endif
							</span>
						</li>
					@endif

					{{-- Set Trip --}}
					@if ($trip->status >= 3 && $trip->id_trip != '') 
						<li class="feed-item feed-item-warning">
							<span class="date fw-bold">
								{{ date("d M Y H:i",strtotime($trip->set_trip_time)) }} 
								<div class="badge badge-warning ml-2">
									<span class="fw-bold">Set Trip</span>
								</div>
							</span>
							<span class="text">
								<span>Perjalanan telah disiapkan, sebagai berikut : </span>
								<div class="row py-1 container">
									<div class="col-md-3 d-flex flex-column justify-content-around">
										<div>
											<h4 class="fw-bold">Waktu Berangkat</h4>
											<span>{{ date("d M Y H:i",strtotime($trip->departure_time)) }}</span>
										</div>
										<br>
										@if ($trip->supir != '')
											<div>
												<h4 class="fw-bold">Driver</h4>
												<span>{{ $trip->supir }}</span>
											</div>
											<br>
										@endif
									</div>
									<div class="col-md-3 d-flex flex-column justify-content-around">
										@if ($trip->kendaraan != '')
											<div>
												<h4 class="fw-bold">Kendaraan</h4>
												<span>{{ $trip->kendaraan }}</span>
											</div>
											<br>
										@endif
										@if ($trip->nopol != '')
											<div>
												<h4 class="fw-bold">No Polisi</h4>
												<span>{{ $trip->nopol }}</span>
											</div>
											<br>
										@endif
										@if ($trip->kendaraan == '' && $vouchers != '')
											<div>
												<h4 class="fw-bold">Kode Voucher</h4>
												@foreach ($vouchers as $v)
													<span>{{ $v->kode_voucher }}</span><br>
												@endforeach
											</div>
											<br>
										@endif
									</div>
								</div>
								<a href="/trip-ticket/{{ $trip->id_trip }}" class="my-2 btn btn-info">
									<div class="d-flex">
										<div>
											<i class="fas fa-ticket-alt"></i>
										</div>
										<div class="ml-2">
											Lihat Tiket
										</div>
									</div>
								</a>
							</span>
						</li>
					@endif

					{{-- Responsed --}}
					@if ($trip->status >= 3) 
						<li class="feed-item feed-item-warning">
							<span class="date fw-bold">
								{{ date("d M Y H:i",strtotime($trip->response_time)) }} 
								<div class="badge badge-warning ml-2">
									<span class="fw-bold">Responsed</span>
								</div>
							</span>
							<span class="text">
								<span>Request kendaraan telah di-response oleh GAD</span>
							</span>
						</li>
					@endif

					{{-- Waiting GAD --}}
					@if ($trip->status >= 2) 
						<li class="feed-item feed-item-primary">
							<span class="date fw-bold">
								{{ date("d M Y H:i",strtotime($trip->approve_time)) }} 
								<div class="badge badge-primary ml-2">
									<span class="fw-bold">Waiting GAD</span>
								</div>
							</span>
							<span class="text">
								Request kendaraan telah di-approve oleh 
								<span class="fw-bold">{{ $trip->approve_by }}</span>
							</span>
						</li>
					@endif
					
					{{-- Waiting Head --}}
					<li class="feed-item feed-item-secondary">
						<time class="date fw-bold">
							{{ date("d M Y H:i",strtotime($trip->input_time)) }} 
							<div class="badge badge-secondary ml-2">
								<span class="fw-bold">Waiting Head</span>
							</div>
						</time>
						<span class="text">
							Request kendaraan berhasil dinput, dengan detil berikut : 
							<div class="row py-1 container">
								<div class="col-md-3 d-flex flex-column justify-content-around">
									<br>
									<div>
										<h4 class="fw-bold">Pemohon</h4>
										<span>{{ $trip->pemohon }}</span>
									</div>
									<br>
									<div>
										<h4 class="fw-bold">Keperluan</h4>
										<span>{{ $trip->keperluan }}</span>
									</div>
									<br>
									<div>
										<h4 class="fw-bold">Jenis Perjalanan</h4>
										<span>
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
									</div>
									<br>
									<div>
										<h4 class="fw-bold">Penumpang</h4>
										<ul>
											@foreach ($penumpangs as $p)
											<li>
												<span>{{ $p->nama }}</span><br>
											</li>
											@endforeach
										</ul>
									</div>
								</div>
								<div class="col-md-3 d-flex flex-column justify-content-around">
									<br>
									<div>
										<h4 class="fw-bold">Tujuan</h4>
										<span>{{ $trip->tujuan.", ".$trip->wilayah }}</span>
									</div>
									<br>
									<div>
										<h4 class="fw-bold">Berangkat</h4>
										<span>{{ date("d M Y H:i",strtotime($trip->waktu_berangkat)) }}</span>
									</div>
									<br>
									<div>
										<h4 class="fw-bold">Pulang</h4>
										<span>{{ $trip->waktu_pulang != ''? date("d M Y H:i",strtotime($trip->waktu_pulang)) : '-' }}</span>
									</div>
									<br>
								</div>
							</div>
						</span>
					</li>
				</ol>

				<div class="d-flex float-right my-3">
					<div class="d-inline mr-2">
						<a href="{{ url('/trip') }}" class="btn btn-secondary float-right">Kembali</a>
					</div>
				</div>
				
            </div>
        </div>
    </div>

@endsection