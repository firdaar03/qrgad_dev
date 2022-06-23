@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Tambah Ruangan</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/ruangan') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mandatory">Nama Ruangan</label>
                            <input name="nama" id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Nama Ruangan">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama" class="mandatory">Lokasi</label>
                            <select name="lokasi" class="form-control @error('lokasi') is-invalid @enderror">
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
                            <label for="lantai" class="mandatory">Lantai</label>
                            <input name="lantai" id="lantai" type="number" class="form-control @error('lantai') is-invalid @enderror"
                            value="{{ old('lantai') }}" min="1" placeholder="Lantai">
                            @error('lantai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kapasitas" class="mandatory">Kapasitas</label>
                            <input name="kapasitas" id="kapasitas" type="number" class="form-control @error('kapasitas') is-invalid @enderror"
                            value="{{ old('kapasitas') }}" min="1" placeholder="Kapasitas">
                            @error('kapasitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fasilitas">Fasilitas</label>
                        </div>

                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover dataTable" >
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="fit text-center">#</th>
                                        <th class="fit text-center">Fasilitas</th>
                                        <th class="fit text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fasilitas as $f)
                                    <tr>
                                        <td class="fit text-center">{{ $loop->iteration }}</td>
                                        <td class="">{{ $f->nama }}</td>
                                        <td class="fill text-center">
                                            <input type='hidden' id='idf[]' name='idf[]' value='{{ $f->id }}'>
                                            <div class="form-group d-flex justify-content-center">
                                                <input placeholder="Jumlah" type='number' id='jumlah[]' name='jumlah[]' class="form-control shadow col-lg-2" value="{{ old('jumlah.'.$loop->index, 0 )}}" min="0">
                                            </div>
                                        </td>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex float-right mt-5 mb-5">
                            <div class="d-inline mr-2">
                                <a href="{{ url('/ruangan') }}" class="btn btn-secondary float-right">Batal</a>
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
