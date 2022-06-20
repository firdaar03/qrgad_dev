@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Tambah Kendaraan</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/kendaraan') }}/{{ $kendaraan->id }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mandatory">Nama Kendaraan</label>
                            <input name="nama" id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $kendaraan->nama) }}" placeholder="Nama Kendaraan">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div id="nopol_container" >
                            <div class="form-group">
                                <label for="nopol" class="mandatory">Nomor Polisi</label>
                                <input name="nopol" id="nopol" type="text" class="form-control @error('nopol') is-invalid @enderror"
                                value="{{ old('nopol', $kendaraan->nopol) }}" placeholder="Nomor Polisi">
                                @error('nopol')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex float-right mt-5 mb-5">
                            <div class="d-inline mr-2">
                                <a href="{{ url('/kendaraan') }}" class="btn btn-secondary float-right">Batal</a>
                            </div>
                            <div class="d-inline">
                                <button type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection