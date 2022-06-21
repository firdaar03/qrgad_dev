@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Tambah Konsumable</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/konsumable') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="mandatory">Nama Konsumable</label>
                            <input name="nama" id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}" placeholder="Nama Konsumable">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kategori_konsumable" class="mandatory">Kategori Konsumable</label>
                            <select name="kategori_konsumable" id="kategori_konsumable" class="form-control @error('kategori_konsumable') is-invalid @enderror"  onchange="filterOption()">
                                <option value="">--Pilih kategori konsumable--</option>
                                @foreach ($kategori_konsumable as $kk)    
                                    <option value="{{ $kk->id }}" {{ old('kategori_konsumable') == $kk->id ? 'selected' : '' }}>{{ $kk->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_konsumable')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group" id="skk_container">
                            <label for="sub_kategori_konsumable" class="mandatory">Sub Kategori Konsumable</label>
                            <select name="sub_kategori_konsumable" id="sub_kategori_konsumable" class="form-control @error('sub_kategori_konsumable') is-invalid @enderror">
                                <option value="" selected>--Pilih sub kategori konsumable--</option>
                                {{-- @foreach ($sub_kategori_konsumable as $skk)    
                                    <option value="{{ $skk->id }}" {{ old('sub_kategori_konsumable') == $skk->id ? 'selected' : '' }}>{{ $skk->nama }}</option>
                                @endforeach --}}
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
                                    <option value="PCS" {{ old('jenis_satuan') == 'PCS' ? 'selected' : '' }}>PCS</option>
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
                            value="{{ old('minimal_stock') }}" min="1" placeholder="minimal stock">
                            @error('minimal_stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
					

                        <div class="mt-4 mb-4">
                            <div>
                                <a href="{{ url('/inventory') }}" class="btn btn-secondary float-right ">Batal</a>
                                <button type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // var skk_array = @json($sub_kategori_konsumable); 
    
        // function filterOption(){
        //     var kategori_konsumable = document.getElementById('kategori_konsumable');
        //     var sub_kategori_konsumable = document.getElementById('sub_kategori_konsumable');
        //     var skk_container = document.getElementById('skk_container');
        //     clearOption();
        //     Array.from(skk_array).forEach(skk => {
        //         if(skk['kategori_konsumable'] == kategori_konsumable.value){
        //             var opt = document.createElement('option');
        //             opt.value = skk['id'];
        //             skk.innerHTML = skk['nama'];
        //             sub_kategori_konsumable.appendChild(opt);
        //         }
        //     });
            
        //     skk_container.style.display = 'block';
                
        // }
    
        function clearOption(){
            $('#sub_kategori_konsumable')
            .find('option')
            .remove()
            .end()
            .append('<option value="" selected disabled>--pilih sub kategori konsumable--</option>')
        }

        function filterOption(){
            clearOption();
            var kategori_konsumable = $('#kategori_konsumable').val();
            $.get("{{ url('/konsumable-filter') }}/"+kategori_konsumable, {}, function(data, status){
                $('#sub_kategori_konsumable').append(data);
            }) 
        }
    </script>

@endsection

@section('script')

    @if (session()->has('alert'))
        @php
            $alert = session()->get('alert');
            $state = explode('-', $alert)[0];
            $action = explode('-', $alert)[1];
            $menu = explode('-', $alert)[2];
        @endphp

        <script>
            var state = @json($state);
            var action = @json($action);
            var menu = @json($menu);

            getAlert(state, action, menu);
        </script>
    @endif  
    
@endsection

