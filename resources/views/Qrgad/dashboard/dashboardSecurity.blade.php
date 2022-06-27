@extends('Qrgad/layout/qrgad-admin')

@section('content')

    {{-- modal --}}
    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Whatsapp</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" hidden>
              </button>
            </div>
            <div class="modal-body" >
                <div class="form-group">
                    <p>Silahkan untuk menambahkan nomor Whatsapp aktif anda</p>
                    {{-- <label for="nama">No Whatsapp</label> --}}
                    <input name="number" id="number" type="text" class="form-control mb-3" onkeypress="return isNumberKey(event)" maxlength="13" placeholder="No Whatsapp">
                    <div id="message" class="invalid-feedback mb-3">Wajib diisi</div>
                    {{-- <button class="btn btn-success float-right" onclick="store()">Tambah</button> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="update('{{ Auth::user()->username }}')">Simpan</button>
            </div>
          </div>
        </div>
    </div>
    
@endsection

@section('script')

    @if (session()->has('alert'))
        @php
            $alert = session()->get('alert');
            $state = explode('-', $alert)[0];
            $action = explode('-', $alert)[1];
            $menu = explode('-', $alert)[2];
        @endphp

        <script>
            var state = @json($state);
            var action = @json($action);
            var menu = @json($menu);

            getAlert(state, action, menu);
        </script>
    @endif  

    <script>
        var addWhatsapp = @json($addWhatsapp); 
        

        $(document).ready(function(){
            if(addWhatsapp == "true"){
                $('#modal').modal('show');
            }
        });

   
        function update(id){
                var nomor = $('#number').val();
                
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                if(nomor == null || nomor == ""){
                    $('#number').addClass('is-invalid');
                    $('#message').show();
                } else {
                    $.ajax({
                        type:"put",
                        url:"{{ url('/user') }}/"+id,
                        data : "nomor="+ nomor,
                        success:function(data){
                            $('.close').click();
                            showAlert('success', 'Tambah Data', 'Berhasil menambahkan data');
                        },error: function(xhr, status, error) {
                            showAlert('danger', 'Tambah Data', 'Gagal menambahkan data');
                        }
                    });
                }
            
                
            }

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            if (document.getElementById('number').value < 1) {
                //alert(“Tidak boleh 0 dulu”);
            if (charCode == 48)
                return false;
            }
            return true;
        }
    </script>
@endsection