
@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header d-flex flex-inline">
				<div class="col">
					<div class="d-flex flex-wrap">
						<h3 class="fw-bold">
							Detail Trip
						</h3>
						<div class="ml-1">
							@php 
								if ($trip->waktu_berangkat_aktual != '' && $trip->waktu_pulang_aktual != ''){
									echo "<div class='badge badge-success'> Sudah Pulang </div>" ;
								} elseif ($trip->waktu_berangkat_aktual != '' && $trip->waktu_pulang_aktual == ''){
									echo "<div class='badge badge-primary'> Sudah Berangkat </div>" ;
								} elseif ($trip->waktu_berangkat_aktual == '' && $trip->waktu_pulang_aktual == ''){
									echo "<div class='badge badge-warning'> Belum Berangkat </div>" ;
								}
							@endphp
						</div>
					</div>
				</div>
				<div class="col-md-2 col-lg-2 col-sm-2">
					<img src="{{ URL::asset('assets\Atlantis-Lite-master\img\patria.png') }} " alt="navbar brand" class="img-fluid img-responsive">
				</div>
            </div>
            <div class="card-body">

				{{-- detail trip --}}
				<div class="card shadow">
					<div class="card-body">
						<div class="container">
							<div class="d-flex flex-wrap">
								<div class="flex-fill justify-content-around">
									<div>
										<h4 class="fw-bold">Kode Trip</h4>
										<span>{{ $trip->id_trip }}</span>
									</div>
									<br>
									<div>
										<h4 class="fw-bold">Keperluan</h4>
										<span>{{ $trip->keperluan }}</span>
									</div>
									
									<br>
								</div>
								<div class="flex-fill justify-content-around">
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
										<h4 class="fw-bold">Kendaraan</h4>
										<span>{{ $trip->kendaraan.' ('.$trip->nopol.")" }}</span>
									</div>
									<br>
								</div>
								<div class="flex-fill justify-content-around">
									<div>
										<h4 class="fw-bold">Tujuan</h4>
										<span>{{ $trip->tujuan.", ".$trip->wilayah }}</span>
									</div>
									<br>
									<div>
										<h4 class="fw-bold">Driver</h4>
										<span>{{ $trip->supir }}</span>
									</div>
									<br>
								</div>
								<div class="flex-fill justify-content-around align-self-start">
									<div>
										<h4 class="fw-bold">Pemohon</h4>
										<span>{{ $trip->pemohon }}</span>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex flex-wrap">

					{{-- plan --}}
					<div class="flex-fill mx-1">
						<div class="card shadow">
							<div class="card-header">
								<h4 class="fw-bold">Plan</h4>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="flex-row">
										<div>
											<h4 class="fw-bold">Berangkat</h4>
											<span>{{ $trip->waktu_berangkat != ''? date("d M Y H:i",strtotime($trip->waktu_berangkat)) : '-' }}</span>
										</div>
									</div>
									<br>
									<div class="flex-row">
										<div>
											<h4 class="fw-bold">Pulang</h4>
											<span>{{ $trip->waktu_pulang != ''? date("d M Y H:i",strtotime($trip->waktu_pulang)) : '-' }}</span>
										</div>
									</div>
									<br>
									<div class="flex-row">
										<div>
											<h4 class="fw-bold">Penumpang</h4>
											@if ($penumpangs == '')
												{{ '-' }}
											@else
												<ul>
													@foreach ($penumpangs as $p)
													<li>
														<span>{{ $p->nama }}</span><br>
													</li>
													@endforeach
												</ul>
											@endif
										</div>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
					
					{{-- aktual --}}
					<div class="flex-fill mx-1">
						<div class="card shadow">
							<div class="card-header">
								<h4 class="fw-bold">Aktual</h4>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="flex-row">
										<div>
											<h4 class="fw-bold">Berangkat</h4>
											<span>{{ $trip->waktu_berangkat_aktual != ''? date("d M Y H:i",strtotime($trip->waktu_berangkat_aktual)) : '-' }}</span>
										</div>
									</div>
									<br>
									<div class="flex-row">
										<div>
											<h4 class="fw-bold">Pulang</h4>
											<span>{{ $trip->waktu_pulang_aktual != ''? date("d M Y H:i",strtotime($trip->waktu_pulang_aktual)) : '-' }}</span>
										</div>
									</div>
									<br>
									<div class="flex-row">
										<div>
											<h4 class="fw-bold">Penumpang</h4>
											@if ( $penumpang_aktuals == '[]')
												{{ '-' }}
											@else
												<ul>
													@foreach ($penumpang_aktuals as $p)
													<li>
														<span>{{ $p->nama }}</span><br>
													</li>
													@endforeach
												</ul>
											@endif
										</div>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex float-right mb-5">
					<div class="d-inline mr-2">
						<a href="{{ url('/trip-schedule') }}" class="btn btn-secondary float-right">Kembali</a>
					</div>
				</div>

            </div>
        </div>
    </div>

    <script>

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    
    </script>
@endsection