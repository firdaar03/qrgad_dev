
@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header d-flex flex-inline">
				<div class="col">
					<h3><b>Detail Trip </b></h3>
				</div>
				<div class="col-md-2">
					<img src="{{ URL::asset('assets\Atlantis-Lite-master\img\patria.png') }} " alt="navbar brand" class="img-fluid img-responsive">
				</div>
            </div>
            <div class="card-body">
				<div class="card shadow full-height">
					<div class="card-body">
						<div class="row container">
							<div class="col d-flex flex-column justify-content-around">
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
							</div>
							<div class="col d-flex flex-column justify-content-around">
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
									<h4 class="fw-bold">Pulang</h4>
									<span>{{ date("d M Y H:i",strtotime($trip->waktu_pulang)) }}</span>
								</div>
								<br>
							</div>
							<div class="col d-flex flex-column justify-content-around">
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
							</div>
							<div class="col d-flex flex-column justify-content-around align-self-start">
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
							
						</div>
					</div>
				</div>

				<div class="d-flex float-right my-3">
					<div class="d-inline mr-2">
						<a href="{{ url('/trip') }}" class="btn btn-secondary float-right">Kembali</a>
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