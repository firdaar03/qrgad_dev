
@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header d-flex flex-inline">
				<div class="col">
					<h3><b>Detail Keluhan</b></h3>
				</div>
				<div class="col-md-2">
					<img src="{{ URL::asset('assets\Atlantis-Lite-master\img\patria.png') }} " alt="navbar brand" class="img-fluid img-responsive">
				</div>
            </div>
            <div class="card-body">
				<div class="card shadow full-height">
					<div class="card-body">
						{{-- <div class="card-title">
							Maintenance
						</div> --}}
						<div class="row py-1">
							<div class="col-md-4 d-flex flex-column justify-content-around">
								<div>
									<h4 class="fw-bold">Kode Keluhan</h4>
									<span>{{ $keluhan->id }}</span>
								</div>
								<br>
								<div>
									<h4 class="fw-bold">Keluhan</h4>
									<span>{{ $keluhan->keluhan }}</span>
								</div>
								<br>
							</div>
							<div class="col-md-4 d-flex flex-column justify-content-around">
								<div>
									<h4 class="fw-bold">Lokasi</h4>
									<span>{{ $keluhan->lokasi }}</span>
								</div>
								<br>
								<div>
									<h4 class="fw-bold">Detail Lokasi</h4>
									<span>{{ $keluhan->detail_lokasi }}</span>
								</div>
							</div>
							<div class="col-md-4 d-flex flex-column justify-content-around">
								<div>
									<h4 class="fw-bold">Pelapor</h4>
									<span>{{ $keluhan->pelapor }}</span>
								</div>
								<br>
								<div>
									<h4 class="fw-bold">Tanggal Laporan</h4>
									<span>{{ date("d M Y H:i",strtotime($keluhan->input_time)) }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card shadow full-height">
					<div class="card-body">
						<div class="card-title mb-4 fw-bold">
							Maintenance
						</div>
						<div class="row py-1">
							<div class="col-md-3 d-flex flex-column">
								<div>
									<h4 class="fw-bold">Jenis Keluhan</h4>
									<span>
										@if ($keluhan->aset == '' && $keluhan->non_aset == '')
											{{ '-' }}
										@else
											@if ($keluhan->aset != '')
												{{ 'Aset' }}
											@else
												{{ 'Non Aset' }}
											@endif
										@endif
									</span>
								</div>
							</div>
							<div class="col-md-3 d-flex flex-column">
								
								<div>
									<h4 class="fw-bold">Solusi</h4>
									<span>{{ ($keluhan->solusi != '')? $keluhan->solusi : '-'  }}</span>
								</div>
							</div>
							<div class="col-md-3 d-flex flex-column">
								<div>
									<h4 class="fw-bold">Barang</h4>
									<span>
										@if ($keluhan->aset == '' && $keluhan->non_aset == '')
											{{ '-' }}
										@else
											@if ($keluhan->aset != '')
												{{ $keluhan->aset }}
											@else
												{{ $keluhan->non_aset }}
											@endif
										@endif
									</span>
								</div>
							</div>
							<div class="col-md-3 d-flex flex-column">
								<div>
									<h4 class="fw-bold">Biaya</h4>
									<span>Rp. {{ ($keluhan->biaya != '')? number_format($keluhan->biaya) : '-' }}</span>
								</div>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-md-4 d-flex flex-column justify-content-around">
								<div>
									<h4 class="fw-bold">NOTE</h4>
									<span>{{ ($keluhan->info_respon != '')? $keluhan->info_respon : '-' }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card shadow full-height">
					<div class="card-body">
						<div class="card-title mb-4 fw-bold">
							Konsumable yang digunakan
						</div>
						<div class="row py-1">
							<div class="table-responsive">
								<table id="table" class="display table table-striped table-hover dataTable" >
									<thead class="bg-primary text-white">
										<tr>
											<td class="text-center">#</td>
											<td>Konsumable</td>
											<td>Jumlah</td>                                              
										</tr>
									</thead>
									<tbody>
										@foreach ($konsumables as $k)
											<tr>
												<td class="fit" class="text-center">{{ $loop->iteration }}</td>
												<td class="fill">{{ $k->konsumable }}</td>
												<td>{{ $k->jumlah }}</td>
											</tr>
										@endforeach
			
										
									</tbody>
									
								</table>
							</div>
						</div>
						<div class="row py-1">
							<div class="mt-5 mr-3 ml-auto">
								<a href="{{ url()->previous() }}" class="btn btn-secondary" >Kembali</a>
							</div>
						</div>
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