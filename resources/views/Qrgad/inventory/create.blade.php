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
                        value="{{ old('konsumable', $id ) }}" placeholder="Nama Konsumable" hidden>

                        <div class="form-group">
                            <label for="nama_konsumable" class="mandatory">Nama Konsumable</label>
                            <input name="nama_konsumable" id="nama_konsumable" type="text" class="form-control @error('nama_konsumable') is-invalid @enderror"
                            value="{{ old('nama_konsumable', $konsumable) }}" placeholder="Nama Konsumable" readonly>
                            @error('nama_konsumable')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah_stock" class="mandatory">Jumlah Ketersediaan</label>
                            <input name="jumlah_stock" id="jumlah_stock" type="number" class="form-control @error('jumlah_stock') is-invalid @enderror"
                            value="{{ old('jumlah_stock') }}" min="1" placeholder="jumlah barang yang akan masuk" onkeyup="nominal()" onmouseup="nominal()">
                            @error('jumlah_stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            <label for="harga_item" class="mandatory">Harga Barang</label>
                            <div class="input-group">
                                <input type="hidden" id="total" >
                                <input name="harga_item" id="harga_item" type="number" min="1"  class="form-control @error('harga_item') is-invalid @enderror"
                                value="{{ old('harga_item') }}" class="form-control" onkeyup="nominal()" onmouseup="nominal()" placeholder="Harga Satuan Barang " required />
                                <span class="input-group-text" id="temp">Rp 0 ,-</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama_toko" class="mandatory">Nama Toko</label>
                            <input name="nama_toko" id="nama_toko" type="text" class="form-control @error('nama_toko') is-invalid @enderror"
                            value="{{ old('nama_toko') }}" placeholder="Nama toko tempat membeli barang">
                            @error('nama_toko')
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

@endsection

@section('script')
    <script>
        function nominal(){
            var harga 	= document.getElementById("harga_item").value;
            var stock   = document.getElementById("jumlah_stock").value;
            var price	= harga * stock;
            document.getElementById("total").value = price;
            var total   = document.getElementById("total").value;
            var jml     = total.length;

            while(jml > 3)
            {
                var rupiah = "." + total.substr(-3) + rupiah;
                var decimal = total.length - 3;
                var total = total.substr(0,decimal);
                var jml = total.length;
            }
            
            var rupiah = "Rp " + total + rupiah + ",-";
            var res = rupiah.replace("undefined", "");
            var temp = document.getElementById("temp").innerHTML = res;
            
        }
    </script>

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