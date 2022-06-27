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
                        @foreach ($trips as $t)
                            <option value="{{ $t->id_trip }}" {{ $t->id_trip == $trip->id_trip ? 'selected' : '' }}>
                                {{ $t->id_trip." | ".$t->kendaraan." | ".$t->nopol }}
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

    <div class="">
        <div class="card shadow">
            <div class="card-header">
                <h3><b>Detil Trip</b></h3>
            </div>
            <div class="card-body">
                <div class="row container">
                    <div class="col d-flex flex-column justify-content-around">
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
                    </div>
                    <div class="col d-flex flex-column justify-content-around">
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
                            <h4 class="fw-bold">Pulang</h4>
                            <span>{{ date("d M Y H:i",strtotime($trip->waktu_pulang)) }}</span>
                        </div>
                        <br>
                    </div>
                    <div class="col d-flex flex-column justify-content-around">
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
                    </div>
                    <div class="col d-flex flex-column justify-content-around">
                        <div>
                            <h4 class="fw-bold">Kendaraan</h4>
                            <span>{{ $trip->kendaraan }}</span>
                        </div>
                        <br>
                        <div>
                            <h4 class="fw-bold">Driver</h4>
                            <span>{{ $trip->supir }}</span>
                        </div>
                        <br>
                    </div>
                    <div class="col d-flex flex-column justify-content-around align-self-start">
                        <div>
                            <h4 class="fw-bold">Penumpang</h4>
                            <ul>
                                @foreach ($penumpangs_plan as $p)
                                    <li>
                                        <span>{{ $p->nama }}</span><br>
                                    </li>    
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col" id="container-checkout" >
            <div class="card shadow">

                <div class="card-header">
                    <h3><b>Cek Keberangkatan </b></h3>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form action="{{ url('/trip-check-out') }}" method="post">
                            @method('post')
                            @csrf

                            <input type="hidden" name="trip" value="{{ $trip->id_trip }}">

                            <div class="form-group">
                                <label for="kilometer_berangkat" class="mandatory">Kilometer Berangkat</label>
                                <div class="input-group">
                                    <input type="number" onkeypress="return angka(event)" min="0" name="kilometer_berangkat" class="form-control @error('kilometer_berangkat') is-invalid @enderror" value="{{ old('kilometer_berangkat', $trip->kilometer_berangkat) }}" placeholder="Kilometer Berangkat" {{ $trip->kilometer_berangkat != ''? 'disabled' : '' }} >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            km
                                        </div>
                                    </div>
                                </div>
                                @error('kilometer_berangkat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
            
                            <div class="form-group">
                                <label for="waktu_berangkat" class="mandatory">Waktu Berangkat</label>
                                <input type="datetime-local" name="waktu_berangkat" min="{{ date('Y-m-d\TH:i', strtotime($trip->waktu_berangkat)) }}" class="form-control form-time-picker @error('waktu_berangkat') is-invalid @enderror" value="{{ date('Y-m-d\TH:i:s', strtotime(old('waktu_berangkat', $trip->departure_time))) }}" {{ $trip->waktu_berangkat_aktual != ''? 'hidden' : '' }}>
                                @error('waktu_berangkat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if ( $trip->waktu_berangkat_aktual != '')
                                    <br>
                                    {{ date("d M Y H:i",strtotime($trip->waktu_berangkat_aktual)) }}
                                @endif
                            </div>
            
                            <div class="form-group">
                                <label for="penumpang">Penumpang</label>
                                <div style="display: {{ $trip->kilometer_berangkat != ''? 'none' : 'block' }}">
                                    <select id="penumpang_chosen" multiple class="form-control chzn-select  @error('penumpang') is-invalid @enderror" onchange="insertPenumpang()" >
                                        <option value="">-- pilih penumpang --</option>
                                        @foreach ($penumpangs as $penumpang)
                                            <option value="{{ $penumpang->username }}" {{ (old('penumpang') == $penumpang->nama)? 'selected' : '' }}>
                                                {{ $penumpang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">nama peminjam diikutsertakan</small>
                                </div>


                                @if ($penumpangs_aktual != '')
                                    <br>
                                    <ul>
                                        @foreach ($penumpangs_aktual as $p)
                                            <li>
                                                <span>{{ $p->nama }}</span><br>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <br>
                                @endif
            
                                <input type="text" id="penumpang" name="penumpang" hidden>
                                @error('penumpang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
            
                            <div style="display: {{ $trip->kilometer_berangkat != '' ? 'none' : 'block' }}">
                                <div class="d-flex float-right mt-5 mb-5">
                                    <div class="d-inline mr-2">
                                        <a href="{{ url('/trip') }}" class="btn btn-secondary float-right">Batal</a>
                                    </div>
                                    <div class="d-inline">
                                        <button {{ $trip->kilometer_berangkat != ''? '' : 'disabled' }} type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col" id="container-checkin">
            <div class="card shadow">
                <div class="card-header">
                    <h3><b>Cek Kepulangan</b></h3>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form action="{{ url('/trip-check-in') }}" method="post">
                            @method('post')
                            @csrf

                            <input type="hidden" name="trip_histori" value="{{ $trip->id_trip_histori }}">
            
                            <div class="form-group">
                                <label for="kilometer_pulang" class="mandatory">Kilometer Pulang</label>
                                <div class="input-group">
                                    <input type="number" onkeypress="return angka(event)" min="{{ $trip->kilometer_berangkat != ''? $trip->kilometer_berangkat : '0'}}" name="kilometer_pulang" class="form-control form-time-picker @error('kilometer_pulang') is-invalid @enderror" value="{{ old('kilometer_pulang', $trip->kilometer_pulang)}}" placeholder="Kilometer Pulang" {{ $trip->kilometer_pulang != 0 ? 'disabled' : '' }}>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            km
                                        </div>
                                    </div>
                                </div>
                                @error('kilometer_pulang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
            
                            <div class="form-group">
                                <label for="waktu_pulang" class="mandatory">Waktu Pulang</label>
                                <input type="datetime-local" name="waktu_pulang" min="{{ date('Y-m-d\TH:i', strtotime($trip->waktu_berangkat_aktual)) }}" value="{{ $trip->waktu_pulang != ''? date('Y-m-d\TH:i', strtotime($trip->waktu_pulang)) : date('Y-m-d\TH:i', strtotime($trip->waktu_berangkat_aktual)) }}" class="form-control form-time-picker @error('waktu_pulang') is-invalid @enderror" {{ $trip->kilometer_pulang != 0? 'hidden' : '' }}>
                                @error('waktu_pulang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if ( $trip->kilometer_pulang != 0)
                                    <br>
                                    {{ date("d M Y H:i",strtotime($trip->waktu_pulang_aktual)) }}
                                @endif
                            </div>
            
                            <div style="display: {{ $trip->kilometer_pulang != 0 ? 'none' : 'block' }}">
                                <div class="d-flex float-right mt-5 mb-5">
                                    <div class="d-inline mr-2">
                                        <a href="{{ url('/trip') }}" class="btn btn-secondary float-right">Batal</a>
                                    </div>
                                    <div class="d-inline">
                                        <button type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <div class="d-flex float-right">
        <div class="d-inline mr-2">
            <a href="{{ url('/trip-check') }}" class="btn btn-secondary float-right">Kembali</a>
        </div>
    </div>
    
    <script>
        function insertPenumpang(){
            $('#penumpang').val($('#penumpang_chosen').val());
        }

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

        function angka(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if ((charCode < 48 || charCode > 57)&&charCode>32){
                return false;
            }
            return true;
        }

    </script>

@endsection

