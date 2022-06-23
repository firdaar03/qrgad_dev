@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="">
            <div class="card-header">
                <h3><b>Tambah Inventory</b></h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <form action="{{ url('/inventory') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input name="konsumable" id="konsumable" type="text" class="form-control @error('konsumable') is-invalid @enderror"
                        value="{{ session()->get('id') != ''? session()->get('id') : $id }}" hidden>

                        <div class="form-group">
                            <label for="nama_konsumable" class="mandatory">Nama Consumable</label>
                            <input name="nama_konsumable" id="nama_konsumable" type="text" class="form-control @error('nama_konsumable') is-invalid @enderror"
                            value="{{ session()->get('konsumable') != ''? session()->get('konsumable') : $konsumable }}" placeholder="Nama Consumable" readonly>
                            @error('nama_konsumable')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah_stock" class="mandatory">Jumlah</label>
                            <input name="jumlah_stock" id="jumlah_stock" type="number" class="form-control @error('jumlah_stock') is-invalid @enderror"
                            value="{{ old('jumlah_stock') }}" min="1" onkeyup="nominal()" placeholder="Jumlah Barang yang akan Masuk" >
                            @error('jumlah_stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            <label for="harga_item" class="mandatory">Harga Barang</label>
                            <div class="input-group">
                                <input hidden id="temp_input" name="harga_item" value="{{ old('harga_item') }}" >
                                <input hidden id="temp_total" name="total" value="{{ old('total') }}" >

                                <div class="input-group-prepend">
                                    <div class="input-group-text"> <span class="input-group-text">Rp.</span></div>
                                </div>
                                
                                <input id="harga_item"  min="1"  class="form-control @error('harga_item') is-invalid @enderror"
                                value="" class="form-control" onkeypress="return angka(event)" onkeyup="nominal()" placeholder="Harga Satuan Barang " required />
                                
                                <div class="input-group-append">
                                    <span class="input-group-text"  >
                                        <div>Rp. </div>
                                        <div id="total"></div>
                                    </span>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_toko" class="mandatory">Nama Toko</label>
                            <input name="nama_toko" id="nama_toko" type="text" class="form-control @error('nama_toko') is-invalid @enderror"
                            value="{{ old('nama_toko') }}" placeholder="Nama Toko Pembelian Barang">
                            @error('nama_toko')
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
            harga_item.value = thousands_separators(temp_input.value);
            total.innerHTML = thousands_separators(temp_total.value);
        });

        function thousands_separators(num){
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");
        }

        function nominal(){
            // var biaya = document.getElementById('biaya');
            // var temp = document.getElementById('temp');
            // var harga 	= document.getElementById("harga_item").value;
            // var stock   = document.getElementById("jumlah_stock").value;
            // var price	= harga * stock;
            // var total   = document.getElementById("total").value;
            // total = price;
            // var jml     = total.length;

            // while(jml > 3)
            // {
            //     var rupiah = "." + total.substr(-3) + rupiah;
            //     var decimal = total.length - 3;
            //     var total = total.substr(0,decimal);
            //     var jml = total.length;
            // }
            
            // var rupiah = "Rp " + total + rupiah + ",-";
            // var res = rupiah.replace("undefined", "");
            // var temp = document.getElementById("temp").innerHTML = res;


            // baru

            var temp_input = document.getElementById('temp_input');
            var temp_total = document.getElementById('temp_total');
            var harga_item = document.getElementById('harga_item');
            var total = document.getElementById('total');
            var stock   = document.getElementById("jumlah_stock");
            var jumlah = '';
            var nominal = '';
            
            nominal = harga_item.value.replace(/,/g,"");
            temp_input.value = nominal;
            harga_item.value = thousands_separators(temp_input.value);

            // jumlahin total harga

            jumlah = stock.value * temp_input.value;
            temp_total.value = jumlah;
            total.innerHTML = thousands_separators(jumlah);
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

@section('script')
    

    @if (session()->has('data'))
    @php
        $data = session()->get('data');
        $state = explode('-', $data['alert'])[0];
        $action = explode('-', $data['alert'])[1];
        $menu = explode('-', $data['alert'])[2];
    @endphp

    <script>
        var state = @json($state);
        var action = @json($action);
        var menu = @json($menu);

        getAlert(state, action, menu);
    </script>
    @endif
@endsection