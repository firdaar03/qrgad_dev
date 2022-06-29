@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h3><b>Pilih Kendaraan</b></h3>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row py-1 container">
                    <div class="col d-flex flex-column justify-content-around">
                        <input type="text" id="id_trip" value="{{ $trip->id_trip }}" hidden>
                        <div>
                            <h4 class="fw-bold">Pemohon</h4>
                            <span>{{ $trip->pemohon }}</span>
                        </div>
                        <br>
                        <div>
                            <h4 class="fw-bold">Agenda</h4>
                            <span>{{ $trip->agenda }}</span>
                        </div>
                        <br>
                        <div>
                            <h4 class="fw-bold">Jenis Perjalanan</h4>
                            <span>
                                @php 
                                    switch ($trip->jenis_perjalanan) {
                                        case 1:
                                            echo "One Way" ;
                                            break;
                                        case 2:
                                            echo "Round Trip" ;
                                            break;
                                    } 
                                @endphp
                            </span>
                        </div>
                        <br>
                        <div>
                            <h4 class="fw-bold">Penumpang</h4>
                            @foreach ($penumpang as $p)
                                <span>{{ $p->nama }}</span><br>
                            @endforeach
                        </div>
                    </div>
                    <div class="col d-flex flex-column justify-content-around">
                        <br>
                        <div>
                            <h4 class="fw-bold">Tujuan</h4>
                            <span>{{ $trip->tujuan.", ".$trip->wilayah }}</span>
                        </div>
                        <br>
                        <div>
                            <h4 class="fw-bold">Berangkat</h4>
                            <span>{{ date("d M Y H:i",strtotime($trip->waktu_berangkat)) }}</span>
                        </div>
                        <br>
                        <div>
                            <h4 class="fw-bold">Pulang</h4>
                            <span>{{ date("d M Y H:i",strtotime($trip->waktu_pulang)) }}</span>
                        </div>
                        <br>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h4 class="fw-bold">Kendaraan</h4>
        </div>
        <div class="card-body">
            <div class="overflow-auto">
                <div class="d-flex flex-wrap justify-content-center my-4">
                    <div class="card card-car shadow mx-1" onclick="confirmSetTrip('')">
                        <div class="card-header">
                            <div class="text-center">
                                <span></span>
                            </div>
                        </div>
                        <div class="card-body ">
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <span>Grab</span>
                            </div>
                        </div>
                    </div>
                    @foreach ($kendaraans as $k)
                        <div class="card card-car {{ $k->booked > 0? 'card-warning' : '' }} shadow mx-1" onclick="confirmSetTrip('{{ $k->id }}')">
                            <div class="card-header">
                                <div class="text-center">
                                    <span>{{ $k->nopol }}</span>
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="text-center">
                                    {{-- <span>{{ $k->id }}</span> --}}
                                    {{-- <span>{{ $k->booked }}</span> --}}
                                    <span>{{ $k->booked > 0? $k->booked : '' }}</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <span>{{ $k->nama }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex float-right mt-5 mb-5">
                <div class="d-inline mr-2">
                    <a href="{{ url('/trip') }}" class="btn btn-secondary float-right">Batal</a>
                </div>
            </div>

        </div>
    </div>

    
    

     {{-- modal --}}
     <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Set Trip ({{ $trip->id_trip }})
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ url('/trip-set-trip') }}/{{ $trip->id_trip }}" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="waktu_berangkat" class="mandatory">Kode Trip</label>
                            <input type="text" class="form-control" disabled value="{{ $trip->id_trip }}">
                            <input name="kendaraan" id="kendaraan" type="text" class="form-control" hidden>
                        </div>
                    
                        <div class="form-group" id="supir_container">
                            <label for="supir">Supir</label>
                            <select name="supir" class="form-control">
                                <option value="">-- pilih supir --</option>
                                @foreach ($supirs as $supir)
                                    <option value="{{ $supir->id }}">
                                        {{ $supir->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group" id="voucher_container" style="display: none">
                            <div class="row">
                                <div class="col">
                                    <label for="kode_voucher[]">Kode Voucher</label>
                                    <input type="text" name ="kode_voucher[]" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="kode_voucher[]">Kode Voucher</label>
                                    <input type="text" name ="kode_voucher[]" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="kode_voucher[]">Kode Voucher</label>
                                    <input type="text" name ="kode_voucher[]" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="kode_voucher[]">Kode Voucher</label>
                                    <input type="text" name ="kode_voucher[]" class="form-control">
                                </div>
                            </div>
                        </div>


                    
                        <div class="form-group">
                            <label for="waktu_berangkat" class="mandatory">Berangkat</label>
                            <input type="datetime-local" name ="departure_time" min="{{ date('Y-m-d\TH:i:s', strtotime($trip->waktu_berangkat)) }}" class="form-control form-time-picker">
                            @error('departure_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <div class="inline">
                            <button class="btn btn-success float-right" type="submit">Submit</button>
                            <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
          </div>
        </div>
    </div>

    
@endsection
    
@section('script')
    

    {{-- @error('waktu_berangkat')
        <script>
            confirmSetTrip('');
            alert('error');
        </script>
    @enderror

    @error('supir')
        <script>
            $('#modal').modal('show');
        </script>
    @enderror  

    @error('kendaraan')
        <script>
            $('#modal').modal('show');
        </script>
    @enderror  --}}

<script>
    
    //load modal konfirmasi set trip
    // function confirmSetTrip(vehicle){
    //     $('#kendaraan').val(vehicle);
    //     if(vehicle == ''){
    //         $('#supir_container').hide();
    //         $('#voucher_container').show();
    //     } else {
    //         $('#supir_container').show();
    //         $('#voucher_container').hide();
    //     }
    //     $('#modal').modal('show');
    // }

    //load modal konfirmasi set trip grab
    function confirmSetTripGrab(vehicle){
        $('#kendaraan').val(vehicle);
        $('#modal').modal('show');
    }

    //load modal konfirmasi set trip
    function confirmSetTrip(vehicle){
        var id = $('#id_trip').val();

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        
        $.ajax({
            type:"post",
            url:"{{ url('/trip-confirm-set-trip') }}/"+id,
            data : "kendaraan="+ vehicle,
            success:function(data){
                $('.modal-content').html(data);
                $('#modal').modal('show');
            },error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                // alert(err.Message);
                showAlert('danger', 'Show Modal', 'Gagal menampilkan modal');
            }
        });
    }

    //update data trip
    function setTrip(id){
        var id = $('#id_trip').val();
        var vehicle = $('#kendaraan').val();
        var driver = $('#supir').val();
        var departure = $('#departure_time').val();
        var vouchers = $('input[name^=kode_voucher]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        
        if(vehicle != ''){
            if(driver == '' || driver == null && departure == '' || departure == null){
                $('#supir').addClass('is-invalid');
                $('#message_supir').show();
                $('#departure_time').addClass('is-invalid');
                $('#message_departure_time').show();
            } else if(driver == '' || driver == null){
                $('#supir').addClass('is-invalid');
                $('#message_supir').show();
                $('#departure_time').removeClass('is-invalid');
                $('#message_departure_time').hide();
            } else if(departure == '' || departure == null) {
                $('#departure_time').addClass('is-invalid');
                $('#message_departure_time').show();
                $('#supir').removeClass('is-invalid');
                $('#message_supir').hide();
            } else {
                $.ajax({
                    type:"post",
                    url:"{{ url('/trip-set-trip') }}/"+id,
                    data : {
                        kendaraan : vehicle,
                        supir : driver,
                        departure_time : departure
                    },
                    success:function(data){
                        $('.close').click();
                        if(data.redirect_url){
                            window.location=data.redirect_url; // or {{url('login')}}
                            // showAlert('success', 'Tambah Data', data);
                        }
                    },error: function(xhr, status, error) {
                        $('.close').click();
                        var err = eval("(" + xhr.responseText + ")");
                        // alert(err.Message);
                        // showAlert('danger', 'Tambah Data', 'Gagal mengatur perjalanan');
                    }
                });
            }
        } else {
            if(departure == '' || departure == null){
                $('#departure_time').addClass('is-invalid');
                $('#message_departure_time').show();
            } else {
                $.ajax({
                    type:"post",
                    url:"{{ url('/trip-set-trip') }}/"+id,
                    data : {
                        kendaraan : vehicle,
                        departure_time : departure,
                        kode_voucher : vouchers
                    },
                    success:function(data){
                        $('.close').click();
                        if(data.redirect_url){
                            window.location=data.redirect_url; // or {{url('login')}}
                            // showAlert('success', 'Tambah Data', 'Berhasil mengatur perjalanan');
                        }
                    },error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        // alert(err.Message);
                        showAlert('danger', 'Tambah Data', 'Gagal mengatur perjalanan');
                    }
                });
            }
        }

        
    }

</script>
    
@endsection

