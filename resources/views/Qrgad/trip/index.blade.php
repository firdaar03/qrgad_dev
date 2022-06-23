@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Tabel Transportation Management System </h4>
                    <a class="btn btn-primary btn-round ml-auto" href="{{ url('/trip/create') }}">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="col-1 disolve">
                                <span>Form TMS</span>
                            </div>
                        </div>
                    </a>
                </div>
                
            </div>
            
            <div class="card-body">

                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="start_date">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tgl_awal">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tgl_akhir">
                    </div>
                    <div class="form-group col-md-1 mt-auto">
                        <a class="btn btn-primary text-white float-right" onclick="read()">
                            <div class="d-flex">
                                <div class="">
                                    <i class="fa fa-filter"></i>
                                </div>
                                <div class= "ml-2">
                                    <span>Filter</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="mt-3" id="table_container">
                    {{-- ajax table --}}
                </div>

            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            {{-- Page by Ajax --}}
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

        $('document').ready(function(){
            read();
        });

        function read(){
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
                
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                type:"post",
                url:"{{ url('/trip-read') }}",
                data : {
                    awal : tgl_awal,
                    akhir : tgl_akhir,
                },
                success:function(data){
                    $('#table_container').html(data);
                },error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    // alert(err.Message);
                }
            });
        }

        //load modal konfirmasi approve head
        function confirmApprove(id){
            $.get("{{ url('/trip-confirm-approve') }}/"+id, {}, function(data, status){
                $('.modal-content').html(data);
                $('#modal').modal('show');
            });
        }

        //update status trip request menjadi waiting GAD
        function approve(id){
            $.ajax({
                type:"get",
                url:"{{ url('/trip-approve') }}/"+id,
                success:function(data){
                    $('.close').click();
                    read();
                    showAlert('success', 'Approve Request', 'Berhasil menyetujui request');
                },error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    $('.close').click();
                    showAlert('danger', 'Approve Request', 'Gagal menyetujui request');
                }
            }); 
        }

        //load modal konfirmasi reject request kendaraan
        function confirmReject(id){
            $.get("{{ url('/trip-confirm-reject') }}/"+id, {}, function(data, status){
                $('.modal-content').html(data);
                $('#modal').modal('show');
            });
        }

        //update status trip request menjadi Rejected
        function reject(id){
            var note = $('#note').val();
                
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            if(note == null || note == ""){
                $('#note').addClass('is-invalid');
                $('#message').show();
            } else {

                $.ajax({
                    type:"post",
                    url:"{{ url('/trip-reject') }}/"+id,
                    data: "keterangan="+ note,
                    success:function(data){
                        $('.close').click();
                        read();
                        showAlert('success', 'Reject Request', 'Berhasil me-reject request');
                    },error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        $('.close').click();
                        showAlert('danger', 'Reject Request', 'Gagal me-reject request');
                    }
                });
                
            }
            
        }

        //load modal konfirmasi respon GAD
        function confirmResponse(id){
            $.get("{{ url('/trip-confirm-response') }}/"+id, {}, function(data, status){
                $('.modal-content').html(data);
                $('#modal').modal('show');
            });
        }

        //update status trip request menjadi Responsed
        function response(id){
            $.ajax({
                type:"get",
                url:"{{ url('/trip-response') }}/"+id,
                success:function(data){
                    $('.close').click();
                    read();
                    showAlert('success', 'Respon Keluhan', 'Berhasil merespon keluhan');
                },error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    $('.close').click();
                    showAlert('danger', 'Respon Keluhan', 'Gagal merespon keluhan');
                }
            }); 
        }

    </script>

@endsection    

