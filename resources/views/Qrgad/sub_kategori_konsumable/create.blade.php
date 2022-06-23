@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="card-header">
            <h3><b>Tambah Sub Kategori Consumable</b></h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ url('/sub-kategori-konsumable') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama" class="mandatory">Nama Sub Kategori Consumable</label>
                        <input name="nama" id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" placeholder="Nama Sub Kategori Consumable">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama" class="mandatory">Kategori Consumable</label>
                        <select name="kategori_konsumable" id="kategori_konsumable" class="form-control @error('kategori_konsumable') is-invalid @enderror">
                            <option value="">--Pilih Kategori Consumable--</option>
                            @foreach ($kategori_konsumable as $k)    
                                <option value="{{ $k->id }}" {{ old('kategori_konsumable') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_konsumable')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/sub-kategori-konsumable') }}" class="btn btn-secondary float-right">Batal</a>
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
        mandatory();
    
    </script>
@endsection