<div class="table-responsive">
    <table id="table" class="table table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th class="text-center">#</th>
                <th class="fill">Fasilitas</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fasilitas as $f)
                <tr>
                    <td class="fit text-center">{{ $loop->iteration }}</td>
                    <td class="fill">{{ $f->nama }}</td>
                    <td class="fit text-center">
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