@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h3><b>Cek Trip</b></h3>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap">
                <div class="form-group">
                    <label for="start_date">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tgl_awal">
                </div>
                <div class="form-group">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tgl_akhir">
                </div>
                <div class="form-group mt-auto full-width-mobile">
                    <a class="btn btn-primary text-white w-100" onclick="filterOption()">
                        <div class="d-flex justify-content-center">
                            <div>
                                <i class="fa fa-filter"></i>
                            </div>
                            <div class= "ml-2">
                                <span>Filter</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <br>
            <div class="d-flex flex-wrap">
                <div class="form-group">
                    <label for="trip">Trip</label>
                    <select name="trip" id="trip" class="form-control">
                        <option value="" selected disabled>-- pilih trip --</option>
                        @foreach ($trips as $trip)
                            <option value="{{ $trip->id_trip }}">
                                {{ $trip->id_trip." | ".$trip->kendaraan." | ".$trip->nopol }}
                            </option>
                        @endforeach
                    </select>
                    <div id="message" class="invalid-feedback mb-3">Wajib diisi</div>
                </div>
                <div class="form-group mt-auto full-width-mobile">
                    <a id="search" class="btn btn-primary text-white w-100" onclick="selectTrip()">
                        <div class="d-flex justify-content-center">
                            <div>
                                <i class="fa fa-search"></i>
                            </div>
                            <div class= "ml-2">
                                <span>Cari</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="form-group mt-auto full-width-mobile">
                    <a class="btn btn-info text-white w-100" href="{{ url('/trip-check-scan') }}">
                        <div class="d-flex justify-content-center">
                            <div>
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div class= "ml-2">
                                <span>Scan</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>

        function clearOption(){
            $('#trip')
            .find('option')
            .remove()
            .end()
            .append('<option value="" selected disabled>--pilih trip--</option>')
        }

        function filterOption(){
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
                
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                type:"post",
                url:"{{ url('/trip-filter') }}",
                data : {
                    awal : tgl_awal,
                    akhir : tgl_akhir,
                },
                success:function(data){
                    clearOption();
                     $('#trip').append(data);
                },error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    // alert(err.Message);
                }
            });

        }

        //show detil trip dan form checkin checkout
        function selectTrip(){
            var trip = $('#trip').val();

            if(trip != "" && trip != null){
                window.location.replace("{{ url('trip-check/') }}"+ "/" + trip);
            } else {
                $('#trip').addClass('is-invalid');
                $('#message').show();
            }
        }

    </script>

@endsection

