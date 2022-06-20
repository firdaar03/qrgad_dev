<div class="table-responsive">
    <table id="table1" class="display table table-striped table-hover dataTable w-100">
        <thead class="bg-primary text-white">
            <tr>
                <td class="text-center">#</td>
                <td>Informasi Keluhan</td>
                <td class="text-center">Lokasi</td>
                <td class="text-center">Waktu</td>
                <td class="text-center">Pelapor</td>
                <td class="text-center">Status</td>
                <td class="text-center">Aksi</td>                                               
            </tr>
        </thead>
        <tbody>
            @foreach ($keluhan as $k)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="fill">{{ $k->keluhan }}</td>
                    <td class="fit">
                        {{ $k->lokasi }}
                        <br>{{ '('.$k->detail_lokasi.')' }}<br>
                    </td>
                    <td class="fit">{{ date("d M Y H:i",strtotime($k->input_time)) }}</td>
                    <td class="fit">{{ $k->pelapor }}</td>
                    <td class="text-center fit">
                        @php 
                            switch ($k->status) {
                                case 0:
                                    echo "<div class='badge badge-danger'> Requested </div>" ;
                                    break;
                                case 1:
                                    echo "<div class='badge badge-warning'> Responded </div>" ;
                                    break;
                                case 2:
                                    echo "<div class='badge badge-success'> Closed </div>" ;
                                    break;
                            } 
                        @endphp
                    </td>
                    <td class="text-center">
                        <div class="form-button-action">
                            @if ($k->status == 1)
                                <a onclick="editResponse('{{ $k->id }}')" type="button" data-toggle="tooltip" rel="tooltip" title="Update Progres" class="btn btn-link btn-warning btn-lg">
                                    <i class="fa fa-walking"></i>
                                </a>
                                <a href="{{ url('/keluhan-dashboard-input-action') }}/{{ $k->id }}" type="button" data-toggle="tooltip" rel="tooltip" title="Action" class="btn btn-link btn-success btn-lg">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <a href="{{ url('/keluhan-dashboard-input-close') }}/{{ $k->id }}" type="button" data-toggle="tooltip" rel="tooltip" title="Close" class="btn btn-link btn-success btn-lg">
                                    <i class="fa fa-check"></i>
                                </a>
                            @endif
                            <a href="{{ url('/keluhan') }}/{{ $k->id }}" type="button" data-toggle="tooltip" rel="tooltip" title="Show" class="btn btn-link btn-info btn-lg">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

<script>
    datatable1();
    tooltip();
</script>