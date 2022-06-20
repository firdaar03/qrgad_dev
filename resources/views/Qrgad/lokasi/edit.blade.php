<div class="modal-header">
    <h5 class="modal-title">
        Edit Lokasi
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="form-group">
        <label for="nama" class="mandatory">Lokasi</label>
        <input name="nama" id="nama" type="text" class="form-control mb-3" value="{{ old('name', $lokasi->nama) }} " placeholder="Nama Lokasi">
        <div id="message" class="invalid-feedback mb-3">Wajib diisi</div>
    </div>
</div>

<div class="modal-footer">
    <div class="inline">
        <button class="btn btn-warning float-right" onclick="update('{{ $lokasi->id }}')">Edit</button>
        <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
    </div>
</div>

<script>
    mandatory();
</script>