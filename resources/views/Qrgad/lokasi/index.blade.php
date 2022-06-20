@extends('Qrgad/layout/qrgad-admin')

@section('content')

    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Data Lokasi</h4>
                    <button class="btn btn-primary btn-round ml-auto" onclick="create()">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="col-1 disolve">
                                <span>Tambah</span>
                            </div>
                        </div>
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
            $.get("{{ url('/lokasi-read') }}",{}, function(data, status){
                $('.card-body').html(data);
            })
        }

        function create(){

            $.get("{{ url('/lokasi/create') }}", {}, function(data, status){
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
                $('#nama').addClass('is-invalid');
                $('#message').show();
            } else {
                $.ajax({
                    type:"post",
                    url:"{{ url('/lokasi') }}",
                    data :"nama="+ name,
                    success:function(data){
                        $('.close').click();
                        read();
                        showAlert('success', 'Tambah Data', 'Berhasil menambahkan data');
                    },error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        // $('.close').click();
                        showAlert('danger', 'Tambah Data', 'Gagal menambahkan data');
                    }
                });
            }
        
            
        }

        function edit(id){
            $.get("{{ url('/lokasi') }}/"+id+"/edit", {}, function(data, status){
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
                    url:"{{ url('/lokasi') }}/"+id,
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
            $.get("{{ url('/lokasi-delete') }}/"+id, {}, function(data, status){
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
                url:"{{ url('/lokasi') }}/"+id,
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
