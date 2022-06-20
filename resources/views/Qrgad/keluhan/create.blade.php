@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="card-header">
            <h3><b>Tambah Keluhan</b></h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ url('/keluhan') }}" method="post">
                    @method('post')
                    @csrf
                    <div class="form-group">
                        <label for="Keluhan" class="mandatory">Keluhan</label>
                        <textarea name="keluhan" id="keluhan" type="text" rows="5" class="form-control @error('keluhan') is-invalid @enderror"
                        placeholder="Keluhan">{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="grup" class="mandatory">Tujuan Laporan</label>
                        <select name="grup" id="grup" class="form-control @error('grup') is-invalid @enderror">
                            <option value="">--Pilih Tujuan--</option>
                            <option value="1" {{ old('grup') == 1 ? 'selected' : '' }}>GAD</option>
                            <option value="2" {{ old('grup') == 2 ? 'selected' : '' }}>MIS</option>
                        </select>
                        @error('grup')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lokasi" class="mandatory">Lokasi</label>
                        <select name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror">
                            <option value="">--Pilih Lokasi--</option>
                            @foreach ($lokasi as $l)    
                                <option value="{{ $l->id }}" {{ old('lokasi') == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                            @endforeach
                        </select>
                        @error('lokasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="detail_lokasi" class="mandatory">Detail lokasi</label>
                        <textarea name="detail_lokasi" id="detail_lokasi" type="text" rows="3" class="form-control @error('detail_lokasi') is-invalid @enderror"
                        placeholder="Detail Lokasi">{{ old('detail_lokasi') }}</textarea>
                        @error('detail_lokasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/keluhan-dashboard') }}" class="btn btn-secondary float-right">Batal</a>
                        </div>
                        <div class="d-inline">
                            <button type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection