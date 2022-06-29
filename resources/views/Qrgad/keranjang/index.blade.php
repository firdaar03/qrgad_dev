<div class="table-responsive">
    <table id="table" class="table table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th class="fit text-center">#</th>
                <th class="">Konsumable</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Aksi</th>
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
                            <a class="btn btn-sm btn-danger text-white align-self-center {{ $k->jumlah > 1? '' : 'disabled'  }}" onclick="update('{{ $k->id }}', -1 )"><i class="fas fa-minus"></i></a>
                            <div class="align-self-center mx-3">
                                <span class="">{{ $k->jumlah }}</span>
                            </div>
                            <a class="btn btn-sm btn-success text-white align-self-center" onclick="update('{{ $k->id }}', 1 )"><i class="fas fa-plus"></i></a>
                        </div>
                    </td>
                    <td class="fit text-center">
                        <div class="btn-group">
                            <a onclick="destroy('{{ $k->id }}')" type="button" data-toggle="tooltip" title="Delete" class="btn btn-link btn-lg btn-danger" >
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    datatable();
    tooltip();
</script>