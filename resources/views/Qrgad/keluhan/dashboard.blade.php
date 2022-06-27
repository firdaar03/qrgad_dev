@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow" onload="read()">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Dashboard Keluhan</h4>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-line nav-fill" id="myTab" role="tablist">
                    <li class="nav-item " role="presentation"  >
                      <button class="nav-link active btn-block" id="requested-tab" data-toggle="tab" data-target="#requested" type="button" role="tab" aria-controls="requested" aria-selected="true">Requested</button>
                    </li>
                    <li class="nav-item" role="presentation" >
                      <button class="nav-link btn-block" id="responded-tab" data-toggle="tab" data-target="#responded" type="button" role="tab" aria-controls="responded" aria-selected="false">Responsed</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="requested" role="tabpanel" aria-labelledby="requested-tab">
                        <div class="mt-5">
                          <div id="request"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="responded" role="tabpanel" aria-labelledby="responded-tab">
                        <div class="mt-5">
                            <div id="response">

                            </div>
                        </div>
                    </div>
                </div>
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
        $(document).ready(function() {
           read();
        });
    
        //load table keluhan status request dan responded
        function read(){
            $.get("{{ url('/keluhan-dashboard-read') }}/request", {}, function(data, status){
                $('#request').html(data);
            });

            $.get("{{ url('/keluhan-dashboard-read') }}/response", {}, function(data, status){
                $('#response').html(data);
            });
        }

        //load modal konfirmasi keluhan
        function confirmResponse(id){
            $.get("{{ url('/keluhan-dashboard-confirm-response') }}/"+id, {}, function(data, status){
                $('.modal-content').html(data);
                $('#modal').modal('show');
            });
        }

        //update status keluhan menjadi responsed
        function response(id){
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
                    url:"{{ url('/keluhan-dashboard-response') }}/"+id,
                    data: "note="+ note,
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
            
        }

         //load modal edit keluhan respon
         function editResponse(id){
            $.get("{{ url('/keluhan-dashboard-edit-response') }}/"+id, {}, function(data, status){
                $('.modal-content').html(data);
                $('#modal').modal('show');
            });
        }

        //update note respon keluhan
        function updateResponse(id){
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
                    url:"{{ url('/keluhan-dashboard-update-response') }}/"+id,
                    data: "note="+ note,
                    success:function(data){
                        $('.close').click();
                        read();
                        showAlert('success', 'Respon Keluhan', 'Berhasil update progres keluhan');
                    },error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        $('.close').click();
                        showAlert('danger', 'Respon Keluhan', 'Gagal update progres keluhan');
                    }
                });
                
            }
        }
    </script>
    
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

@endsection    

