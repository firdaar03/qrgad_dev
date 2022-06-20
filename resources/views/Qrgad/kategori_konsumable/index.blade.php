@extends('Qrgad/layout/qrgad-admin')

@section('content')

    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Data Kategori Konsumable</h4>
                    <button class="btn btn-primary btn-round ml-auto" onclick="create()">
                        <i class="fa fa-plus mr-1"></i>
                        Tambah
                    </button>
                </div>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            {{-- CRUD Page by Ajax --}}
          </div>
        </div>
    </div>

    <script>

            $(document).ready(function(){
                read();
                
            });

            function read(){
                $.get("{{ url('/kategori-konsumable-read') }}",{}, function(data, status){
                    $('.card-body').html(data);
                    // alert(data);
                })
            }

            function create(){

                $.get("{{ url('/kategori-konsumable/create') }}", {}, function(data, status){
                    // alert(data);
                    $('.modal-title').html('Tambah Data');
                    $('.modal-content').html(data);
                    $('#modal').modal('show');
                }) 
            }

            function store(){
                var name = $('#nama').val();
                
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                if(name == null || name == ""){
                    // alert('tidal boleh kosong');
                    $('#nama').addClass('is-invalid');
                    $('#message').show();
                } else {
                    $.ajax({
                        type:"post",
                        url:"{{ url('/kategori-konsumable') }}",
                        data : "nama="+ name,
                        success:function(data){
                            // $('.modal-content').html('');
                            $('.close').click();
                            // alert(name);
                            read();
                            showAlert('success', 'Tambah Data', 'Berhasil menambahkan data');
                        },error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            // alert(err.Message);
                            $('.close').click();
                            showAlert('danger', 'Tambah Data', 'Gagal menambahkan data');
                        }
                    });
                }
            
                
            }

            function edit(id){
                $.get("{{ url('/kategori-konsumable') }}/"+id+"/edit", {}, function(data, status){
                    $('.modal-title').html('Edit Data');
                    $('.modal-content').html(data);
                    $('#modal').modal('show');
                }) 
            }

            function update(id){
                var name = $('#nama').val();
                
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                if(name == null || name == ""){
                    $('#nama').addClass('is-invalid');
                    $('#message').show();
                } else {
                    $.ajax({
                        type:"put",
                        url:"{{ url('/kategori-konsumable') }}/"+id,
                        data : "nama="+ name,
                        success:function(data){
                            $('.close').click(); 
                            read();
                            showAlert('success', 'Edit Data', 'Berhasil memperbarui data');
                        },error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            // alert(err.Message);
                            $('.close').click();
                            showAlert('danger', 'Edit Data' , 'Gagal memperbarui data!');
                        }
                    });
                }
            }

            function del(id){
                $.get("{{ url('/kategori-konsumable-delete') }}/"+id, {}, function(data, status){
                    $('.modal-title').html('Hapus Data');
                    $('.modal-content').html(data);
                    $('#modal').modal('show');
                }) 
            }

            function destroy(id){
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                $.ajax({
                    type:"delete",
                    url:"{{ url('/kategori-konsumable') }}/"+id,
                    success:function(data){
                        $('.close').click();
                        read();
                        showAlert('success', 'Hapus Data', 'Berhasil menghapus data!');
                    },error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        // alert(err.Message);
                        $('.close').click();
                        showAlert('danger', 'Hapus Data', 'Gagal menghapus data!');
                    }
                });
            }
            
        </script>

@endsection
