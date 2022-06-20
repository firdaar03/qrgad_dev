@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Edit Konsumable</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/konsumable') }}/{{ $k->id }}" method="post">
                        @method("put")
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mandatory">Nama Konsumable</label>
                            <input name="nama" id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $k->nama) }}" placeholder="Nama Konsumable">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori_konsumable" class="mandatory">Kategori Konsumable</label>
                            <select name="kategori_konsumable" id="kategori_konsumable" class="form-control @error('kategori_konsumable') is-invalid @enderror">
                                <option value="">--Pilih kategori konsumable--</option>
                                @foreach ($kategori_konsumable as $kk)  
                                    <option value="{{ $kk->id }}" {{ (old('kategori_konsumable', $k->kategori_konsumable) == $kk->id) ? 'selected' : '' }}>{{ $kk->nama }}</option>  
                                @endforeach
                            </select>
                            @error('kategori_konsumable')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sub_kategori_konsumable" class="mandatory">Sub Kategori Konsumable</label>
                            <select name="sub_kategori_konsumable" id="sub_kategori_konsumable" class="form-control @error('sub_kategori_konsumable') is-invalid @enderror">
                                <option value="">--Pilih sub kategori konsumable--</option>
                                @foreach ($sub_kategori_konsumable as $skk)    
                                    <option value="{{ $skk->id }}" {{ (old('sub_kategori_konsumable', $k->sub_kategori_konsumable) == $skk->id) ? 'selected' : '' }}>{{ $skk->nama }}</option>  
                                @endforeach
                            </select>
                            @error('sub_kategori_konsumable')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_satuan" class="mandatory">Jenis Satuan</label>
                            <select name="jenis_satuan" id="jenis_satuan" class="form-control @error('jenis_satuan') is-invalid @enderror">
                                <option value="">--Pilih jenis satuan--</option>   
                                    <option value="PCS" {{ (old('jenis_satuan', $k->jenis_satuan) == 'PCS') ? 'selected' : '' }}>PCS</option>
                                    <option value="PCK" {{ (old('jenis_satuan', $k->jenis_satuan) == 'PCK') ? 'selected' : '' }}>PCK</option>
                            </select>
                            @error('jenis_satuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="minimal_stock" class="mandatory">Minimal Stock</label>
                            <input name="minimal_stock" id="minimal_stock" type="number" class="form-control @error('minimal_stock') is-invalid @enderror"
                            value="{{ old('minimal_stock', $k->minimal_stock) }}" min="1" placeholder="minimal stock">
                            @error('minimal_stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex float-right mt-5 mb-5">
                            <div class="d-inline mr-2">
                                <a href="{{ url('/inventory') }}" class="btn btn-secondary float-right">Batal</a>
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


