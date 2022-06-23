<div class="table-responsive">
    <table id="table" class="display table table-striped table-hover dataTable" >
        <thead class="bg-primary text-white">
            <tr>
                <td class="text-center">#</td>
                <td>Keperluan</td>
                <td>Jenis Perjalanan</td>
                <td>Berangkat</td>
                <td>Pulang</td>
                <td>Tujuan</td>
                <td>Status</td>
                <td class="text-center">Aksi</td>                                               
            </tr>
        </thead>
        <tbody>
            @foreach ($trip_request as $tr)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="fill">{{ $tr->keperluan }}</td>
                    <td class="fit">
                        @php 
                            switch ($tr->jenis_perjalanan) {
                                case 1:
                                    echo "One Way" ;
                                    break;
                                case 2:
                                    echo "Round Trip" ;
                                    break;
                            } 
                        @endphp
                    </td>
                    <td class="fit">{{ date("d M Y H:i",strtotime($tr->waktu_berangkat)) }}</td>
                    <td class="fit">{{ $tr->waktu_pulang != ''? date("d M Y H:i",strtotime($tr->waktu_pulang)) : '-' }}</td>
                    <td class="fit">{{ $tr->tujuan.", ".$tr->wilayah }}</td>
                    
                    <td class="text-center fit">
                        @php 
                            switch ($tr->status) {
                                case 0:
                                    echo "<div class='badge badge-danger'> Rejected </div>" ;
                                    break;
                                case 1:
                                    echo "<div class='badge badge-secondary'> Waiting Head </div>" ;
                                    break;
                                case 2:
                                    echo "<div class='badge badge-primary'> Waiting GAD </div>" ;
                                    break;
                                case 3:
                                    echo "<div class='badge badge-warning'> Responded </div>" ;
                                    break;
                                case 4:
                                    echo "<div class='badge badge-success'> Closed </div>" ;
                                    break;
                            } 
                        @endphp
                    </td>
                    <td class="text-center">
                        <div class="form-button-action">
                            <a href="{{ url('/trip/'.$tr->id_trip_request) }}" type="button" data-toggle="tooltip" rel="tooltip" title="Show" class="btn btn-link btn-info btn-lg">
                                <i class="fa fa-eye"></i>
                            </a>

                            {{-- Responsed --}}
                            @if ($tr->status == '3')
                                @if ($tr->kendaraan != '')
                                    <a href="{{ url('/trip-ticket') }}/{{ $tr->id_trip }}" type="button" data-toggle="tooltip" rel="tooltip" title="Ticket" class="info btn-lg">
                                        <i class="fas fa-ticket-alt"></i>
                                    </a>
                                @endif
                            @endif
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