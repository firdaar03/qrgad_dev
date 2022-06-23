<div class="table-responsive">
    <table id="table1" class="table table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th class="fit text-center">#</th>
                <th class="">Konsumable</th>
                <th class="text-center">Jumlah</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($keranjang as $k)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td >
                        {{ $k->konsumable }}
                        <input type="" name="konsumable[]" value="{{ $k->id_konsumable }}" hidden>
                    </td>
                    <td class="d-flex justify-content-center">
                        <input name="jumlah[]" value="{{ $k->jumlah }}" hidden>
                        <div class="d-flex d-inline">
                            <div class="align-self-center mx-3">
                                <span class="">{{ $k->jumlah }}</span>
                            </div>
                        </div>
                    </td>
                    
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>