@extends('Qrgad/layout/qrgad-admin')

@section('content')

    {{-- modal --}}
    <div class="modal" id="myModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content" data-background-color="bg3">
            <div id="modal-body">

            </div>
        </div>
        </div>
    </div>


    {{-- main content --}}
    <div id="alert" class="mb-2">
        {{-- @if($errors->any())
        <h4>{{$errors->first()}}</h4>
        @endif --}}
    </div>
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3 fw-bold">Tambah Jadwal Meeting Room</h4>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('/jadwal-ruangan') }}" method="post" class="container">
                    @csrf

                    <div class="form-group">
                        <label for="agenda" class="mandatory">Agenda</label>
                        <textarea type="text" rows="3" name="agenda" class="form-control @error('agenda') is-invalid @enderror" placeholder="Agenda" >{{ old('agenda') }}</textarea>
                        @error('agenda')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="perusahaan">Perusahaan</label>
                        <div class="d-flex">
                            <div class="d-inline flex-fill mr-1" id="input-perusahaan">
                                <select name="perusahaan" id="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror">
                                    <option value="">-- pilih perusahaan --</option>
                                    @foreach ($perusahaans as $perusahaan)
                                        <option value="{{ $perusahaan->id }}" {{ (old('perusahaan') == $perusahaan->id )? 'selected' : '' }}>{{ $perusahaan->nama }}</option>
                                    @endforeach
                                </select>
                                @error('perusahaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-inline">
                                <div class="btn btn-primary" onclick="createPerusahaan()">
                                    <div class="row">
                                        <div class="col-1">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="disolve">
                                            <span>Tambah</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="fw-light"> Pilih perusahaan jika keperluan meeting room dengan perusahaan </span>
                        </div>
                        
                        @error('perusahaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ruangan" class="mandatory">Ruangan</label>
                        <select  name="ruangan" id="ruangan" class="form-control @error('ruangan') is-invalid @enderror">
                            <option value="">-- pilih ruangan --</option>
                            @foreach ($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}" {{ (old('ruangan') == $ruangan->id)? 'selected' : '' }}>
                                    {{ $ruangan->nama }} (Kapasitas :  {{ $ruangan->kapasitas }} orang)
                                </option>
                            @endforeach
                        </select>
                        @error('ruangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    {{-- tanggal --}}
                    <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}" hidden>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="start" class="mandatory">Mulai</label>
                                <input type="datetime-local" id="datetimepicker1"  pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}" name="start" min="{{ date('Y-m-d\TH:i:s', strtotime($tanggal)) }}" max="{{ date('Y-m-d\TH:i:s', strtotime($tanggal.'23:59:59')) }}" class="form-control form-time-picker @error('start') is-invalid @enderror" value="{{ old('start') == null? date('Y-m-d\TH:i:s', strtotime($tanggal)) : old('start') }}" >
                                @error('start')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-1 mt-auto">
                            <label class="pb-3 fw-bold"> - </label>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="end" class="mandatory">Sampai</label>
                                <input type="datetime-local" id="datetimepicker2" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}" min="{{ date('Y-m-d\TH:i:s', strtotime($tanggal)) }}" name="end" class="form-control form-time-picker @error('end') is-invalid @enderror" value="{{ old('end') == null? date('Y-m-d\TH:i:s', strtotime($tanggal)) : old('end') }}">
                                @error('end')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color">Warna</label>

                        <div class="row container">
                            <input type="radio" name="color" id="red" value="#DB2828" {{ (old('color')=='#DB2828')? 'checked' : '' }}/>
                            <label class="label" for="red"><span class="red"></span></label>
    
                            <input type="radio" name="color" id="green" value="#21BA45" {{ (old('color')=='#21BA45')? 'checked' : '' }}/>
                            <label class="label" for="green"><span class="green"></span></label>
    
                            <input type="radio" name="color" id="yellow" value="#FBBD08" {{ (old('color')=='#FBBD08')? 'checked' : '' }}/>
                            <label class="label" for="yellow"><span class="yellow"></span></label>
    
                            <input type="radio" name="color" id="olive" value="#B5CC18" {{ (old('color')=='#B5CC18')? 'checked' : '' }}/>
                            <label class="label" for="olive"><span class="olive"></span></label>
    
                            <input type="radio" name="color" id="orange" value="#F2711C" {{ (old('color')=='#F2711C')? 'checked' : '' }}/>
                            <label class="label" for="orange"><span class="orange"></span></label>
    
                            <input type="radio" name="color" id="teal" value="#00B5AD" {{ (old('color')=='#00B5AD')? 'checked' : '' }}/>
                            <label class="label" for="teal"><span class="teal"></span></label>
    
                            <input type="radio" name="color" id="blue" value="#2185D0" {{ (old('color')=='#2185D0')? 'checked' : '' }}/>
                            <label class="label" for="blue"><span class="blue"></span></label>
    
                            <input type="radio" name="color" id="violet" value="#6435C9" {{ (old('color')=='#6435C9')? 'checked' : '' }}/>
                            <label class="label" for="violet"><span class="violet"></span></label>
    
                            <input type="radio" name="color" id="purple" value="#A333C8" {{ (old('color')=='#A333C8')? 'checked' : '' }}/>
                            <label class="label" for="purple"><span class="purple"></span></label>
    
                            <input type="radio" name="color" id="pink" value="#E03997" {{ (old('color')=='#E03997')? 'checked' : '' }}/>
                            <label class="label" for="pink"><span class="pink"></span></label>
                        </div>
                    </div>
                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/jadwal-ruangan') }}" class="btn btn-secondary float-right">Batal</a>
                        </div>
                        <div class="d-inline">
                            <button type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                        </div>
                    </div>
                </form>
                <br><br>
                {{-- <div class="col-md-2 mt-auto">
                    <div class="form-group ">
                        <button id="btn_cek" class="btn btn-info pb-6" onclick="cekJadwal()">Cek Jadwal</button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <script>
                
        function readPerusahaan(){
            $.get("{{ url('/perusahaan-read') }}",{}, function(data, status){
                $('#input-perusahaan').html(data);
            });
        }

        function createPerusahaan(){
            $.ajax({
                    type:'get',
                    url: "{{ url('/perusahaan/create') }}",
                    success:function(data){
                        $('#modal-body').html(data);
                        $('#myModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err);
                        $('.close').click();
                    }
                });
        }

        function storePerusahaan(){
            var name = $('#nama').val();
                
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            if(name == null || name == ""){
                $('#nama').addClass('is-invalid');
                $('#message').show();
            } else {
                $.ajax({
                    type:"post",
                    url:"{{ url('/perusahaan') }}",
                    data : "nama="+ name,
                    success:function(data){
                        // $('.modal-body').html('');
                        $('.close').click();
                        readPerusahaan();
                        showAlert('success', 'Tambah Data', 'Berhasil menambahkan data perusahaan');
                    },error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        // alert(err.Message);
                        $('.close').click();
                        showAlert('danger', 'Tambah Data', 'Gagal menambahkan data');
                    }
                });
            }
        }
    </script>
@endsection

@section('script')

    @if ( session()->has('errorDate'))
        <script>
            $(document).ready(function(){
                cekJadwal();
            });
        </script>
    @endif
    
    <script>
       
        function cekJadwal(){

            var tanggal = $('input[name=tanggal]').val();
            var start = $('input[name=start]').val();
            var end = $('input[name=end]').val();
            var ruangan = $('select[name=ruangan] option').filter(':selected').val();

            if(tanggal != '' && start != '' && end != ''){

                $.ajax({
                    type:'get',
                    url: "{{ url('/jadwal-ruangan-validate-date') }}",
                    data : {
                        date:tanggal,
                        room:ruangan,
                        start:start,
                        end:end
                    },
                    success:function(data){
                        $('#modal-body').html(data);
                        $('#myModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        $('.close').click();
                    }
                });
            }

        }
        
    </script>
@endsection