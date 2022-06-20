
@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Detail Ruangan</b></h3>
            </div>
            <div class="card-body">
                <div class="row">
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-primary bubble-shadow-small">
												<i class="flaticon-home"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Nama Ruangan</p>
												<h4 class="card-title">{{ $r->nama }}</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-info bubble-shadow-small">
												<i class="flaticon-placeholder"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Lokasi</p>
												@foreach ($lokasi as $l)  
													@if($r->lokasi == $l->id)  
														<h4 class="card-title">{{ $l->nama }}</h4>
													@endif
												@endforeach
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-success bubble-shadow-small">
												<i class="flaticon-graph"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Lantai</p>
												<h4 class="card-title">{{ $r->lantai }}</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-secondary bubble-shadow-small">
												<i class="flaticon-users"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Kapasitas</p>
												<h4 class="card-title">{{ $r->kapasitas }} orang</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="fasilitas">Fasilitas</label>
					</div>
                        
                    <div class="form-group">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover dataTable" >
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="fit text-center">#</th>
                                        <th class="fit" style="text-align: center">Fasilitas</th>
                                        <th class="fit" style="text-align: center">Ketersediaan</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($fasilitas as $f)
										<tr>
                                            <td class="fit text-center">{{ $loop->iteration }}</td>
											<td class="fit">{{ $f->nama }}</td>
											<td class="fit text-center">
												@php $istrue = false; @endphp 
												@foreach ($dtruang as $dt)
													@if($f->id == $dt->fasilitas)
														@php $istrue = true; @endphp 
														<div class="badge badge-success"> <span class="fw-bold">{{ $dt->jumlah }} Buah</span> </div>
													@endif
												@endforeach 
												@if(!$istrue)
													<div class="badge badge-danger"> <span class="fw-bold">0 Buah</span> </div>
												@endif
											</td>
										</tr>
									@endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex float-right mt-5 mb-5">
						<div class="d-inline mr-2">
							<a href="{{ url('/ruangan') }}" class="btn btn-secondary float-right">Kembali</a>
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