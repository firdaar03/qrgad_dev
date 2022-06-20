<div class="modal-header">
    <h5 class="modal-title">
        Edit Lokasi Maintain
    </h5>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="form-group">
        <label for="nama" class="mandatory">Lokasi Maintain</label>
        <input name="nama" id="nama" type="text" class="form-control mb-3" value="{{ $lokasi_maintain->nama }} " placeholder="Nama Lokasi maintain">
        <div id="message" class="invalid-feedback mb-3">Wajib diisi</div>
    </div>
</div>

<div class="modal-footer">
    <div class="inline">
        <button class="btn btn-warning float-right" onclick="update('{{ $lokasi_maintain->id }}')">Edit</button>
        <button class="btn btn-secondary float-right mr-1" data-bs-dismiss="modal">Batal</button>
    </div>
</div>

<script>
    mandatory();
</script>