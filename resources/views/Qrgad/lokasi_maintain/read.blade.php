<div class="table-responsive">
    <table id="table" class="display table table-striped table-hover">
        <thead class="bg-primary text-white">
            <tr>
                <th class="fit">#</th>
                <th >Lokasi</th>
                <th class="text-center fit">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lokasi_maintain as $l)
                <tr>
                    <td class="fit">{{ $loop->iteration }}</td>
                    <td >{{ $l->nama }}</td>
                    <td class="align-content-center fit">
                        <div class="form-button-action">
                            {{-- <a href="/lokasi/{{ $f->id }}/show" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-success btn-lg" data-original-title="Info">
                                <i class="fa fa-eye"></i>
                            </a> --}}
                            <a onclick="edit('{{ $l->id }}')" type="button" data-toggle="tooltip" title="Edit" class="btn btn-link btn-warning btn-lg">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a onclick="del('{{ $l->id }}')" type="button" data-toggle="tooltip" title="Delete" class="btn btn-link btn-lg btn-danger">
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