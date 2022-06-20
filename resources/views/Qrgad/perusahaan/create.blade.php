<div class="modal-header">
    <h5 class="modal-title">
        Tambah Perusahaan 
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="nama" class="mandatory">Perusahaan</label>
        <input name="nama" id="nama" type="text" class="form-control mb-3" placeholder="Nama Perusahaan">
        <div id="message" class="invalid-feedback mb-3">Wajib diisi</div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-primary" onclick="storePerusahaan()">Simpan</button>
</div>
</div>

<script>
    mandatory();
</script>