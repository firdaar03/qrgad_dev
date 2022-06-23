@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Edit Consumable</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/konsumable') }}/{{ $k->id }}" method="post">
                        @method("put")
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mandatory">Nama Consumable</label>
                            <input name="nama" id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $k->nama) }}" placeholder="Nama Consumable">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori_konsumable" class="mandatory">Kategori Consumable</label>
                            <select name="kategori_konsumable" id="kategori_konsumable" class="form-control @error('kategori_konsumable') is-invalid @enderror" onchange="filterOption()">
                                <option value="">--Pilih Kategori Konsumable--</option>
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
                            <label for="sub_kategori_konsumable" class="mandatory">Sub Kategori Consumable</label>
                            <select name="sub_kategori_konsumable" id="sub_kategori_konsumable" class="form-control @error('sub_kategori_konsumable') is-invalid @enderror">
                                <option value="">--Pilih Sub Kategori Konsumable--</option>
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
                                <option value="Pcs" {{ old('jenis_satuan', $k->jenis_satuan) == 'Pcs' ? 'selected' : '' }}>Pieces</option>
                                <option value="Unit" {{ old('jenis_satuan', $k->jenis_satuan) == 'Unit' ? 'selected' : '' }}>Unit</option>
                                <option value="Pak" {{ old('jenis_satuan', $k->jenis_satuan) == 'Pak' ? 'selected' : '' }}>Pak</option>
                                <option value="Rim" {{ old('jenis_satuan', $k->jenis_satuan) == 'Rim' ? 'selected' : '' }}>Rim</option>
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
                            value="{{ old('minimal_stock', $k->minimal_stock) }}" min="1" placeholder="Minimal Stock">
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

    <script>

        $(document).ready(function(){
            {{ old('kategori_konsumable', $kategori_konsumable) != ''?  'filterOption();' : ''}}
        });
    
        function clearOption(){
            $('#sub_kategori_konsumable')
            .find('option')
            .remove()
            .end()
            .append('<option value="" selected disabled>--Pilih Sub Kategori Konsumable--</option>')
        }

        function filterOption(){
            clearOption();
            var kategori_konsumable = $('#kategori_konsumable').val();
            $.get("{{ url('/konsumable-filter') }}/"+kategori_konsumable, {}, function(response){
                // alert(data.length);
                for(var item in response){
                    console.log(response[item]);
                    var old = '{{ old('sub_kategori_konsumable', $k->sub_kategori_konsumable) }}';
                    var selected = '';
                    if(response[item]['id'] == old){
                        selected = "selected";
                    } 
                    $('#sub_kategori_konsumable').append("<option value="+response[item]['id']+" "+selected+" >"+response[item]['nama']+"</option>")
                }
            }) 
        }

        

    </script>

@endsection


