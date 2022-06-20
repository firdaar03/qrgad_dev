<div class="table-responsive">
    <table id="table" class="table table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th class="col-sm-1 text-center">#</th>
                <th class="col-sm-3">Fasilitas</th>
                <th class="col-sm-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fasilitas as $f)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td >{{ $f->nama }}</td>
                    <td class="">
                        <div class="btn-group">
                            <a onclick="edit('{{ $f->id }}')" type="button" data-toggle="tooltip" title="Edit" class="btn btn-link btn-warning btn-lg" >
                                <i class="fa fa-edit"></i>
                            </a>
                            <a onclick="del('{{ $f->id }}')" type="button" data-toggle="tooltip" title="Delete" class="btn btn-link btn-lg btn-danger" >
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