<div class="table-responsive">
    <table id="table" class="display table table-striped table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th class="col-sm-1 text-center">#</th>
                <th class="col-sm-3">Nama Kategori Konsumable</th>
                <th class="col-sm-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori_konsumable as $kk)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td >{{ $kk->nama }}</td>
                    <td class="text-center">
                        <div class="form-button-action text-center">
                            <a onclick="edit('{{ $kk->id }}')" type="button" data-toggle="tooltip" title="Edit" class="btn btn-link btn-warning btn-lg">                                 <i class="fa fa-edit"></i>
                            </a>
                            <a onclick="del('{{ $kk->id }}')" type="button" data-toggle="tooltip" title="Delete" class="btn btn-link btn-lg btn-danger" >
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