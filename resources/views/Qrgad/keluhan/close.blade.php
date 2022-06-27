@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="card-header">
            <h3><b>Closing Keluhan</b></h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ url('/keluhan-dashboard-close') }}" method="post">
                    @method('post')
                    @csrf

                    <div class="d-flex flex-wrap">
                        <input type="text" name="keluhan" id="keluhan" value="{{ $keluhan->id }}" hidden>
                        <div class="flex-fill">
                            <div class="form-group">
                                <label for="keluhan">Keluhan</label>
                                <textarea  rows="2" class="form-control" disabled>{{ $keluhan->keluhan }}</textarea>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <textarea rows="2" class="form-control" disabled>{{ $keluhan->lokasi." (". $keluhan->detail_lokasi.")" }}</textarea>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="form-group">
                                <label for="pelapor">Pelapor</label>
                                <input type="text" class="form-control" value="{{ $keluhan->pelapor }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap my-2">
                        <div class="flex-fill">
                            <div class="form-group">
                                <label for="solusi" class="mandatory">Solusi</label>
                                <textarea type="text" rows="2" name="solusi" class="form-control @error('solusi') is-invalid @enderror" placeholder="Solusi" >{{ old('solusi') }}</textarea>
                                @error('solusi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="form-group">
                                <label for="biaya" class="mandatory">Biaya</label>
                                <input type="text" id="biaya" name="biaya" value="{{ old('biaya') }}" hidden>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"> <span>Rp.</span></div>
                                    </div>
                                    <input name="temp" id="temp" type="text"  onkeypress="return angka(event)" class="form-control @error('biaya') is-invalid @enderror"
                                     placeholder="Biaya" onkeyup="separator()" onload="">
                                </div>
                                @error('biaya')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="form-group">
                                <label for="kategori" class="mandatory">Kategori</label>
                                <div class="d-flex d-inline">
                                    <div class=" flex-fill mr-1" id="input-kategori">
                                        <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                            <option value="" disabled selected>-- pilih kategori --</option>
                                            <option value="0" {{ (old('kategori') == '0' )? 'selected' : '' }}>Ringan</option>
                                            <option value="1" {{ (old('kategori') == '1' )? 'selected' : '' }}>Sedang</option>
                                            <option value="2" {{ (old('kategori') == '2' )? 'selected' : '' }}>Berat</option>
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                @error('kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>

                    

                    <div class="form-group">
                        <label for="jenis_keluhan" class="mandatory">Jenis Keluhan</label>
                        <select name="jenis_keluhan" id="jenis_keluhan" 
                        onchange="jenisKeluhanCheck()" class="form-control @error('jenis_keluhan') is-invalid @enderror">
                            <option value="" disabled selected>-- pilih jenis keluhan --</option>
                            <option value="Aset" {{ (old('jenis_keluhan') == 'Aset' )? 'selected' : '' }}>Aset</option>
                            <option value="Non Aset" {{ (old('jenis_keluhan') == 'Non Aset' )? 'selected' : '' }}>Non Aset</option>
                        </select>
                        @error('jenis_keluhan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div id="aset_container" style="display: {{ old('jenis_keluhan') == 'Aset'? 'block' : 'none'  }}">
                        <div class="d-flex flex-wrap my-2">
                            <div class="flex-fill">
                                <div class="form-group">
                                    <label class="mandatory" for="grup_aset">Grup Aset</label>
                                    <select name="grup_aset" id="grup_aset" class="form-control @error('grup_aset') is-invalid @enderror" onchange="filterOption()">
                                        <option value="" >-- pilih grup aset --</option>
                                        @foreach ($grup_asets as $ga)
                                            <option value="{{ $ga->id }}" {{ old('grup_aset') == $ga->id ? 'selected' : '' }} >{{ $ga->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('grup_aset')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex-fill" id="sga_container" style="display: none">
                                <div class="form-group">
                                    <label class="mandatory" for="sub_grup_aset">Sub Grup Aset</label>
                                    <select name="sub_grup_aset" id="sub_grup_aset" class="form-control @error('sub_grup_aset') is-invalid @enderror">
                                        <option value=""  selected>-- pilih sub grup aset --</option>
                                        {{-- @foreach ($sub_grup_asets as $sga)
                                        <option value="{{ $sga->id }}" {{ old('sub_grup_aset') == $sga->id? 'selected' : '' }} >{{ $sga->nama }}</option>
                                        @endforeach --}}
                                    </select>
                                    @error('sub_grup_aset')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="non_aset_container" style="display: {{ old('jenis_keluhan') == 'Non Aset'? 'block' : 'none'  }}">
                        <div class="form-group">
                            <label for="non_aset" class="mandatory">Non Aset</label>
                            <input name="non_aset" id="non_aset" type="text" class="form-control @error('non_aset') is-invalid @enderror"
                            value="{{ old('non_aset') }}" placeholder="Non Aset yang Digunakan">
                            @error('non_aset')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex float-right my-5">
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

    <script>
        var sga_array = @json($sub_grup_asets); //get data sub grup aset
        // alert(sub_grup_aset);
        var biaya = document.getElementById('biaya');
        var temp = document.getElementById('temp');
        
        $(document).ready(function(){
            temp.value = thousands_separators(biaya.value);
            {{ old('grup_aset') != ''? 'filterOption()' : '' }}
        });

        
        function separator(){
            var nominal = temp.value.replace(/,/g,"");
            biaya.value = nominal
            temp.value = thousands_separators(nominal);
        }

        function thousands_separators(num){
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");
        }

        function jenisKeluhanCheck(){
            var jenisKeluhan = document.getElementById('jenis_keluhan').value;
            var aset = document.getElementById('aset_container');
            var non_aset = document.getElementById('non_aset_container');
            var sga_container = document.getElementById('sga_container');
            var grup_aset = document.getElementById('grup_aset');

            switch(jenisKeluhan){
                case 'Aset' : 
                    aset.style.display = 'block';
                    non_aset.style.display = 'none';
                    break;
                case 'Non Aset' : 
                    aset.style.display = 'none';
                    sga_container.style.display = 'none';
                    grup_aset.value = '';
                    non_aset.style.display = 'block';
                    break;
                }
            }
            
            
        //     function filterOption(){
        //         var grup_aset = document.getElementById('grup_aset');
        //         var sub_grup_aset = document.getElementById('sub_grup_aset');
        //         var sga_container = document.getElementById('sga_container');
                
                
        //         clearOption();
        //         sga_array.forEach(sga => {
        //             if(sga['grup_aset'] == grup_aset.value){
        //                 var opt = document.createElement('option');
        //                 opt.value = sga['id'];
        //                 opt.innerHTML = sga['nama'];

        //                 sub_grup_aset.appendChild(opt);
        //             }
        //         });
                
        //         sga_container.style.display = 'block';
                
        // }

        function clearOption(){
            $('#sub_grup_aset')
            .find('option')
            .remove()
            .end()
            .append('<option value="" selected disabled>--pilih sub grup aset--</option>')
        }

        function filterOption(){
            var grubAset = $('#grup_aset').val();

            clearOption();
            $.get("{{ url('/keluhan-dashboard-filter-sub-grup-aset') }}/"+grubAset, {}, function(response, status){
                // alert(data);
                for(var item in response){
                    console.log(response[item]);
                    var old = '{{ old('sub_grup_aset') }}';
                    var selected = '';
                    if(response[item]['id'] == old){
                        selected = "selected";
                    } 
                    $('#sub_grup_aset').append("<option value="+response[item]['id']+" "+selected+" >"+response[item]['nama']+"</option>")
                }
                $('#sga_container').show();
            }) 

        }

        function angka(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if ((charCode < 48 || charCode > 57)&&charCode>32){
                return false;
            }
            return true;
        }

    </script>
@endsection