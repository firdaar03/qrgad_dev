<div class="modal-header">
    <h4 class="modal-title">
        Response Request Kendaraan
    </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="card shadow">
		<div class="card-header">
			<h4 class="fw-bold">Yakin me-response request kendaraan ini ?</h4>
		</div>
		<div class="card-body">
			<div class="row py-1 container">
				<div class="col d-flex flex-column justify-content-around">
					<div>
						<h4 class="fw-bold">Pemohon</h4>
						<span>{{ $trip_request->pemohon }}</span>
					</div>
					<br>
					<div>
						<h4 class="fw-bold">Keperluan</h4>
						<span>{{ $trip_request->keperluan }}</span>
					</div>
					<br>
					<div>
						<h4 class="fw-bold">Jenis Perjalanan</h4>
						<span>
							@php 
								switch ($trip_request->jenis_perjalanan) {
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
						@foreach ($penumpangs as $p)
						<span>{{ $p->nama }}</span><br>
						@endforeach
					</div>
					<br>
				</div>
				<div class="col d-flex flex-column justify-content-around">
					<div>
						<h4 class="fw-bold">Tujuan</h4>
						<span>{{ $trip_request->tujuan.", ".$trip_request->wilayah }}</span>
					</div>
					<br>
					<div>
						<h4 class="fw-bold">Berangkat</h4>
						<span>{{ date("d M Y H:i",strtotime($trip_request->waktu_berangkat)) }}</span>
					</div>
					<br>
					<div>
						<h4 class="fw-bold">Pulang</h4>
						<span>{{ date("d M Y H:i",strtotime($trip_request->waktu_pulang)) }}</span>
					</div>
					<br>
					<div>
						<h4 class="fw-bold">Di-approve Oleh</h4>
						<span>{{ $trip_request->approve_by }}</span>
					</div>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
    <div class="inline">
        <button class="btn btn-success float-right" onclick="response('{{ $trip_request->id_trip_request }}')">Response</button>
        <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
    </div>
</div>


