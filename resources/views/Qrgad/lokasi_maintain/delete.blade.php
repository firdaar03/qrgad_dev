<div class="modal-header">
    <h5 class="modal-title">
        Hapus Lokasi
    </h5>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <p class="mb-3">Yakin ingin menghapus data?</p>
</div>

<div class="modal-footer">
    <div class="inline">
        <button class="btn btn-danger float-right" onclick="destroy('{{ $id }}')">Hapus</button>
        <button class="btn btn-secondary float-right mr-1" data-bs-dismiss="modal">Batal</button>
    </div>
</div>