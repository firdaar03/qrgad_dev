@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Edit Ruangan</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/ruangan') }}/{{ $r->id }}" method="post">
                        @method("put")
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mandatory">Nama Ruangan</label>
                            <input name="nama" id="nama" type="text" class="form-control @error('nama') is-ivalid @enderror" value="{{ old('nama', $r->nama) }}" 
                            placeholder="Kapasitas">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="nama" class="mandatory">Lokasi</label>
                            <select name="lokasi" id="lokasi" class="form-control @error('lokasi') is-ivalid @enderror">
                                @foreach ($lokasi as $l)  
                                    @if( old('lokasi', $r->lokasi) == $l->id)  
                                        <option value="{{ $l->id }}" selected>{{ $l->nama }}</option>
                                    @else
                                        <option value="{{ $l->id }}" >{{ $l->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="lantai" class="mandatory">Lantai</label>
                            <input name="lantai" id="lantai" type="number" class="form-control @error('lantai') is-invalid @enderror"
                            value="{{ old('lantai', $r->lantai) }}" min="1" placeholder="Lantai"  onkeypress="return angka(event)">
                            @error('lantai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kapasitas" class="mandatory">Kapasitas</label>
                            <input name="kapasitas" id="kapasitas" type="number" class="form-control @error('kapasitas') is-invalid @enderror"
                            value="{{ old('kapasitas', $r->kapasitas) }}" min="1" placeholder="Kapasitas"  onkeypress="return angka(event)">
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
                                            <td class="fit">{{ $f->nama }}</td>
                                            <td class="fit text-center">
                                                <input type='hidden' id='idf[]' name='idf[]' value='{{ $f->id }}'>
                                                @php $istrue = false; @endphp 
                                                @foreach ($dtruang as $dt)
                                                    @if($f->id == $dt->fasilitas)
                                                        @php $istrue = true; @endphp 
                                                        <div class="form-group  d-flex justify-content-center">
                                                            <input type='number' id='jumlah[]' name='jumlah[]' class="form-control col-md-3" value="{{ old('jumlah.'.$loop->iteration-1, $dt->jumlah )}}" min="0"
                                                            onkeypress="return angka(event)">
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if(!$istrue)
                                                    <div class="form-group  d-flex justify-content-center">
                                                        <input type='number' id='jumlah[]' name='jumlah[]' class="form-control col-md-3" value="{{ old('jumlah.'.$loop->iteration-1, 0) }}" min="0">
                                                    </div>
												@endif
                                                {{-- <input type='checkbox' name='idf[]' value='{{ $f->id }}'  --}}
                                                {{-- @foreach ($dtruang as $dt) --}}
                                                    {{-- @if(is_array(old('idf', $f->id)) && in_array($f->id, old('idf', $f->id)) || (old('fasilitas', $f->id) == $dt->fasilitas) ) checked @endif --}}
                                                    {{-- {{ (old('fasilitas', $f->id) == $dt->fasilitas)? 'checked' : '' }} --}}
                                                {{-- @endforeach> --}}
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

<script>
    function angka(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 48 || charCode > 57)&&charCode>32){
            return false;
        }
        return true;
    }
</script>


