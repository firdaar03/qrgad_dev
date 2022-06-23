@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="card-header">
            <h3><b>Closing Keluhan</b></h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ url('/keluhan-dashboard-action') }}" method="post">
                    @method('post')
                    @csrf

                    
                    <div class="d-flex flex-wrap">
                        <input id="complain" name="keluhan" type="text" value="{{ $keluhan->id }}" hidden>
                        <div class="flex-fill">
                            <div class="form-group">
                                <label>Keluhan</label>
                                <textarea  rows="2" class="form-control" disabled>{{ $keluhan->keluhan }}</textarea>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <textarea rows="2" class="form-control" disabled>{{ $keluhan->lokasi." (". $keluhan->detail_lokasi.")" }}</textarea>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="form-group">
                            
                                <label for="pelapor">Pelapor</label>
                                <input type="text" class="form-control" value="{{ $keluhan->pelapor }}" disabled>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex d-inline">
                        <div class="flex-fill">
                            <div class="form-group">
                                <label class="mandatory">Konsumble</label>
                                <select id="konsumable" class="form-control" onchange="createAmountInput()">
                                    <option value="">--Pilih Konsumable--</option>
                                    @foreach ($konsumable as $k)    
                                        <option value="{{ $k->id_konsumable }}">{{ $k->nama_konsumable }} ( available stock : {{ $k->stock - $k->minimal_stock }}) </option>
                                    @endforeach
                                </select>
                                <div id="konsumable_error" class="invalid-feedback">
                                    Konsumable wajib dipilih
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex-fill">
                            <div class="form-group">
                                <label class="mandatory">Jumlah</label>
                                <div id="jumlah_container">
                                    <input id="jumlah" type="number" class="form-control" min="1" placeholder="Jumlah"  onkeypress="return angka(event)">
                                </div>
                                <div id="jumlah_error" class="invalid-feedback">
                                    Jumlah wajib diisi
                                </div>
                            </div>
                        </div>
                        <div class="flex-fill align-self-end mb-3">
                            <a class="btn btn-success ml-auto text-white" onclick="store()">
                                <div class="row">
                                    <div class="col-1">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <div class="col-1 disolve">
                                        <span>Tambah</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div id="table_keranjang" class="mt-3">
                        {{-- ajax read request --}}
                    </div>

                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/keluhan-dashboard') }}" class="btn btn-secondary float-right">Batal</a>
                        </div>
                        <div class="d-inline">
                            <a class="btn btn-primary float-right mr-3 text-white" onclick="confirmStore()">Simpan</a>
                        </div>
                    </div>

                    {{-- modal --}}
                    <div class="modal" id="modal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content" data-background-color="bg3">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Tambah Item Out
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div id="modal-body">
                                    <div class="container">
                                        <div class="mt-3 mb-3">
                                            <span >Yakin menambahkan konsumable berikut untuk keluhan ini ?</span>
                                        </div>
                                        <div id="confirm_table" class="table" ></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="inline">
                                        <button class="btn btn-success float-right" type="submit">Tambah</button>
                                        <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    

    <script>
        var container = document.getElementById('container');

        // $(document).ready(function(){
        //     var value = parseInt(document.getElementById('count').value, 10);
        //     if (value != 0){
        //         for(i=1; i<=value; i++){
        //             addKonsumable();
        //         }
        //     }
        // });

        $(document).ready(function(){
                read();
            });


        function createAmountInput(){
            var konsumable = $('#konsumable').val();
            
            resetJumlah();
            // alert(konsumable);

            $.get("{{ url('/keluhan-dashboard-get-limit-stock') }}/"+konsumable+"", {}, function(data, status){
                $('#jumlah').remove();
                $('#jumlah_container').append('<input id="jumlah" type="number" class="form-control" min="1" max='+data+' placeholder="Jumlah" onkeyup="alertAmount('+data+')">');
            })
        }

        function alertAmount(limit){
            var jumlah = $('#jumlah');
            var jumlah_error = $('#jumlah_error');
        

            if(jumlah.val()>limit){
                jumlah.addClass('is-invalid');
                jumlah.val('');
                jumlah_error.html('Stok yang tersedia hanya '+limit);
                jumlah_error.show();
            } else {
                resetJumlah();
            }
        }

        function resetJumlah(){
            var jumlah = $('#jumlah');
            var jumlah_error = $('#jumlah_error');

            jumlah.removeClass('is-invalid');
            jumlah_error.html('Jumlah wajib diisi');
            jumlah_error.hide();

        }

        function read(){
            $.get("{{ url('/keranjang') }}",{}, function(data, status){
                $('#table_keranjang').html(data);
                // alert(data);
            })
        }

        function store(){
            var consumable = $('#konsumable').val();
            var total = $('#jumlah').val();
            var complaint = String($('#complain').val());
            
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            if(consumable == "" && total == ""){
                // alert('tidal boleh kosong');
                $('#konsumable').addClass('is-invalid');
                $('#konsumable_error').show();
                $('#jumlah').addClass('is-invalid');
                $('#jumlah_error').show();
                
            } else if(consumable == "" ){
                // alert('tidal boleh kosong');
                $('#konsumable').addClass('is-invalid');
                $('#konsumable_error').show();
                $('#jumlah').removeClass('is-invalid');
                $('#jumlah_error').hide();
                
            } else if(total == ""){
                // alert('tidal boleh kosong');
                $('#konsumable').removeClass('is-invalid');
                $('#konsumable_error').hide();
                $('#jumlah').addClass('is-invalid');
                $('#jumlah_error').show();
                
            } else {
                // alert(consumable+"-"+total+"-"+complaint);
                $.ajax({
                    type:"post",
                    url:"{{ url('/keranjang') }}",
                    data : {konsumable: consumable, jumlah: total, keluhan: complaint},
                    success:function(data){
                        
                        if(data == 'err_add_konsumable'){
                            showAlert('warning', 'Tambah Data' , 'Konsumable sudah ada, silahkan menambah jumlah item');
                        } else {
                            read();
                            showAlert('success', 'Tambah Data', 'Berhasil menambahkan item konsumable');
                        }

                        $('#konsumable').val('');
                        $('#jumlah').val('');
                        
                    },error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        showAlert('danger', 'Tambah Data', 'Gagal menambahkan item konsumable');
                    }
                });
            }
        
            
        }

        function update(id, amount){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                type:"put",
                url:"{{ url('/keranjang') }}/"+id,
                data : "amount="+ amount,
                success:function(data){
                    read();
                    if(data == 'err_add_amount'){
                        showAlert('warning', 'Update Jumlah' , 'Jumlah item yang ditambahkan melebihi stok yang tersedia');
                    } else {
                        showAlert('success', 'Update Jumlah' , 'Berhasil memperbarui jumlah konsumable');
                    }
                },error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    showAlert('danger', 'Update Jumlah' , 'Gagal memperbarui jumlah konsumable!');
                }
            });
        }

        function destroy(id){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                type:"delete",
                url:"{{ url('/keranjang') }}/"+id,
                success:function(data){
                    read();
                    showAlert('success', 'Hapus Data', 'Berhasil menghapus item konsumable');
                },error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    showAlert('danger', 'Hapus Data' , 'Gagal menghapus item konsumable!');
                }
            });
        }

        function confirmStore(){
            $.get("{{ url('/keranjang-view') }}", {}, function(data, status){
                // alert(data);
                $('.modal-title').html('Tambah Action');
                $('#confirm_table').html(data);
                $('#modal').modal('show');
            }) 
        }

        function angka(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 48 || charCode > 57)&&charCode>32){
            return false;
        }
        return true;
    }

    </script>
@endsection

@section('script')
    
    @if (session()->has('data'))
        @php
            $data = session()->get('data');
            $state = explode('-', $data['alert'])[0];
            $action = explode('-', $data['alert'])[1];
            $menu = explode('-', $data['alert'])[2];
        @endphp

        <script>
            var state = @json($state);
            var action = @json($action);
            var menu = @json($menu);

            getAlert(state, action, menu);
        </script>
    @endif

@endsection
