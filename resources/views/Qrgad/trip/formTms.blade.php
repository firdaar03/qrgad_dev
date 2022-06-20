@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="card-header">
            <h3><b>Form Request Kendaraan</b></h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ url('/trip') }}" method="post">
                    @method('post')
                    @csrf

                    <div class="form-group">
                        <label for="agenda" class="mandatory">Agenda</label>
                        <textarea name="agenda" id="agenda" type="text" rows="3" class="form-control @error('agenda') is-invalid @enderror"
                        placeholder="Agenda">{{ old('agenda') }}</textarea>
                        @error('agenda')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="tujuan" class="mandatory">Tujuan</label>
                                <input name="tujuan" id="tujuan" type="text" class="form-control mb-3 @error('tujuan') is-invalid @enderror" placeholder="Tujuan">
                                @error('tujuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label for="wilayah" class="mandatory">Wilayah</label>
                                <input name="wilayah" id="wilayah" type="text" class="form-control mb-3 @error('wilayah') is-invalid @enderror" placeholder="Wilayah">
                                @error('wilayah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea name="keperluan" id="keperluan" type="text" rows="3" class="form-control @error('keperluan') is-invalid @enderror"
                        placeholder="Keperluan">{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenis_perjalanan" class="mandatory">Jenis Perjalanan</label>
                        <select name="jenis_perjalanan" id="jenis_perjalanan" onchange="checkJenisPerjalanan()" class="form-control @error('jenis_perjalanan') is-invalid @enderror">
                            <option value="">--pilih jenis perjalanan--</option>
                            <option value="1" {{ old('jenis_perjalanan') == 1 ? 'selected' : '' }}>One Way</option>
                            <option value="2" {{ old('jenis_perjalanan') == 2 ? 'selected' : '' }}>Round Trip</option>
                            <option value="3" {{ old('jenis_perjalanan') == 3 ? 'selected' : '' }}>Shuttle</option>
                        </select>
                        @error('jenis_perjalanan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="waktu_berangkat" class="mandatory">Berangkat</label>
                                <input type="datetime-local" id="waktu_berangkat" name="waktu_berangkat" min="{{ date('Y-m-d\TH:i', strtotime($tanggal)) }}" class="form-control form-time-picker @error('waktu_berangkat') is-invalid @enderror" value="{{ old('waktu_berangkat') == null? '' : old('waktu_berangkat') }}" onchange="setMinWaktuPulang()" >
                                @error('waktu_berangkat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col" id="waktu_pulang_container" style="display: {{ old('jenis_perjalanan') == '2'? 'block' : 'none'  }}">
                            <div class="form-group">
                                <label for="waktu_pulang" class="mandatory">Pulang</label>
                                <input type="datetime-local" id="waktu_pulang" name="waktu_pulang"  class="form-control form-time-picker @error('waktu_pulang') is-invalid @enderror" value="{{ old('waktu_pulang') }}">
                                @error('waktu_pulang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="penumpang">Penumpang</label>
                        <select id="penumpang_chosen" multiple class="form-control chzn-select  @error('penumpang') is-invalid @enderror" onchange="insertPenumpang()">
                            <option value="">-- pilih penumpang --</option>
                            @foreach ($penumpangs as $penumpang)
                                <option value="{{ $penumpang->username }}" {{ (old('penumpang') == $penumpang->nama)? 'selected' : '' }}>
                                    {{ $penumpang->nama }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">nama anda diikutsertakan</small>

                        <input type="text" id="penumpang" name="penumpang" hidden>
                        @error('penumpang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/trip') }}" class="btn btn-secondary float-right">Batal</a>
                        </div>
                        <div class="d-inline">
                            <button type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <script>
        function insertPenumpang(){
            $('#penumpang').val($('#penumpang_chosen').val());
        }

        function checkJenisPerjalanan(){

            var jenis_perjalanan = $('#jenis_perjalanan').val();

            if(jenis_perjalanan == 2){
                $('#waktu_pulang_container').show();
            } else {
                $('#waktu_pulang_container').hide();
            }
        }

        function setMinWaktuPulang(){
            var berangkat = document.getElementById('waktu_berangkat');
            var pulang = document.getElementById('waktu_pulang');

            // alert(berangkat.value);
            pulang.setAttribute('min', berangkat.value);
        }
    </script>

@endsection

