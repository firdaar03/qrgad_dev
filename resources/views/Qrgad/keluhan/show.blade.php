
@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header d-flex flex-inline">
				<div class="col">
					<h3><b>Detail Keluhan</b></h3>
				</div>
            </div>
            <div class="card-body">
				<ol class="activity-feed">
					@if ($keluhan->status == 2) 
						<li class="feed-item feed-item-success">
							<span class="date fw-bold">
								{{ date("d M Y H:i",strtotime($keluhan->input_time)) }} 
								<div class="badge badge-success ml-2">
									<span class="fw-bold">Closed</span>
								</div>
							</span>
							<span class="text">
								Laporan keluhan telah diselesaikan
							</span>
						</li>
					@endif

					@if ($keluhan->status == 1 || $keluhan->status == 2) 
						<li class="feed-item feed-item-warning">
							<span class="date fw-bold">
								{{ date("d M Y H:i",strtotime($keluhan->respon_time)) }} 
								<div class="badge badge-warning ml-2">
									<span class="fw-bold">Responsed</span>
								</div>
							</span>
							<span class="text">
								Keluhan telah direspon oleh 
								<span class="fw-bold">{{ $keluhan->responden }}</span> dan akan segera diperbaiki/ diselesaikan
								<br><br>
								<b>NOTE :</b>
								<br>
								<span>
									 {{ $keluhan->info_respon }}
								</span>
							</span>
						</li>
					@endif
					
					<li class="feed-item feed-item-danger">
						<time class="date fw-bold">
							{{ date("d M Y H:i",strtotime($keluhan->input_time)) }} 
							<div class="badge badge-danger ml-2">
								<span class="fw-bold">Requested</span>
							</div>
						</time>
						<span class="text">
							Laporan Keluhan 
							<span class="fw-bold">{{ $keluhan->keluhan }}</span> yang terjadi di  
							<span class="fw-bold">{{ $keluhan->lokasi.' ('.$keluhan->detail_lokasi.')' }}</span> berhasil diinput 
						</span>
					</li>
				</ol>
            </div>
        </div>
    </div>

    <script>

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    
    </script>
@endsection