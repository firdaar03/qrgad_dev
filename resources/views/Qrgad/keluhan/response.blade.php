<div class="table-responsive">
    <table id="table1" class="display table table-striped table-hover dataTable w-100">
        <thead class="bg-primary text-white">
            <tr>
                <td class="text-center">#</td>
                <td>Kode Keluhan</td>
                <td>Keluhan</td>
                <td class="text-center">Lokasi</td>
                <td class="text-center">Waktu</td>
                <td class="text-center">Pelapor</td>
                <td class="text-center">Status</td>                                              
            </tr>
        </thead>
        <tbody>
            @foreach ($keluhan as $k)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <button class="btn btn-border dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            {{ $k->id }}
                        </button>
                        <div id="dropdown" class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(-79px, -104px, 0px); top: 0px; left: 0px; will-change: transform;">
                            {{-- responsed --}}
                            @if ($k->status == 1)
                                <a onclick="editResponse('{{ $k->id }}')" class="dropdown-item text-warning">
                                    Update Progress
                                </a>
                                <a href="{{ url('/keluhan-dashboard-input-action') }}/{{ $k->id }}" class="dropdown-item text-warning">
                                    Action
                                </a>
                                <a href="{{ url('/keluhan-dashboard-input-close') }}/{{ $k->id }}" class="dropdown-item text-success">
                                    Close 
                                </a>
                            @endif
                            
                            <a href="{{ url('/keluhan') }}/{{ $k->id }}" class="dropdown-item text-info">
                                Show
                            </a>
                        </div>
                    </td>
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
                    
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

<script>
    datatable1();
    tooltip();
</script>