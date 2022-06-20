<div class="modal-header">
    <h5 class="modal-title">
        Respon Keluhan
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="card shadow">
		<div class="card-header">
			<p class="fw-bold">Yakin merespon keluhan ini ?</p>
		</div>
		<div class="card-body">
			<div class="row py-1 container">
				<div class="col-md-4 d-flex flex-column justify-content-around">
					<div>
						<h5 class="fw-bold">Kode Keluhan</h5>
						<span>{{ $keluhan->id }}</span>
					</div>
					<br>
					<div>
						<h5 class="fw-bold">Keluhan</h5>
						<span>{{ $keluhan->keluhan }}</span>
					</div>
					<br>
				</div>
				<div class="col-md-4 d-flex flex-column justify-content-around">
					<div>
						<h5 class="fw-bold">Lokasi</h5>
						<span>{{ $keluhan->lokasi }}</span>
					</div>
					<br>
					<div>
						<h5 class="fw-bold">Detail Lokasi</h5>
						<span>{{ $keluhan->detail_lokasi }}</span>
					</div>
					<br>
				</div>
				<div class="col-md-4 d-flex flex-column justify-content-around">
					<div>
						<h5 class="fw-bold">Pelapor</h5>
						<span>{{ $keluhan->pelapor }}</span>
					</div>
					<br>
					<div>
						<h5 class="fw-bold">Tanggal</h5>
						<span>{{ date("d M Y H:i",strtotime($keluhan->input_time)) }}</span>
					</div>
					<br>
				</div>
			</div>
			<div class="form-group">
				<label for="note" class="mandatory">Catatan</label>
				<textarea name="note" id="note" rows="5" class="form-control mb-3" placeholder="Catatan untuk pelapor"></textarea>
				<div id="message" class="invalid-feedback mb-3">Wajib diisi</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
    <div class="inline">
        <button class="btn btn-success float-right" onclick="response('{{ $keluhan->id }}')">Ya</button>
        <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
    </div>
</div>

<script>
    mandatory();
</script>

