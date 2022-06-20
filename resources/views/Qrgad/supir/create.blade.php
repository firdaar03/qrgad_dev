@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Tambah Driver</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/supir') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mandatory">Nama Driver</label>
                            <input name="nama" id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Nama Driver">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kontak" class="mandatory">Nomor HP</label>
                            <input name="kontak" id="kontak" type="number" class="form-control @error('kontak') is-invalid @enderror"
                            value="{{ old('kontak') }}" placeholder="Nomor HP">
                            <small>Pastikan nomor HP yang diinputkan aktif dan terhubung dengan Whatsapp</small>
                            @error('kontak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex float-right mt-5 mb-5">
                            <div class="d-inline mr-2">
                                <a href="{{ url('/supir') }}" class="btn btn-secondary float-right">Batal</a>
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