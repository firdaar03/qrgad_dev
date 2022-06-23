<div class="modal-header">
    <h5 class="modal-title">
        Tambah Kategori Consumble
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="form-group">
        <label for="nama" class="mandatory">Nama Kategori Consumable</label>
        <input name="nama" id="nama" type="text" class="form-control mb-3" placeholder="Nama Kategori Consumable">
        <div id="message" class="invalid-feedback mb-3">Wajib diisi</div>
    </div>
</div>

<div class="modal-footer">
    <div class="inline">
        <button class="btn btn-success float-right" onclick="store()">Tambah</button>
        <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
    </div>
</div>

<script>
    mandatory();
</script>