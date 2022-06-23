<div class="table-responsive">
    <table id="table" class="display table table-striped table-hover dataTable" >
        <thead class="bg-primary text-white">
            <tr>
                <td class="text-center">#</td>
                <td>Kode Trip Request</td>
                <td>Pemohon</td>
                <td>Jenis Perjalanan</td>
                <td>Berangkat</td>
                <td>Pulang</td>
                <td>Tujuan</td>
                <td>Status</td>                                            
            </tr>
        </thead>
        <tbody>
            @foreach ($trip_request as $tr)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <button class="btn btn-border dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            {{ $tr->id_trip_request }}
                        </button>
                        <div id="dropdown" class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(-79px, -104px, 0px); top: 0px; left: 0px; will-change: transform;">
      
                            {{-- Waiting Head --}}
                            @if ($tr->status == '1')
                                <a onclick="confirmReject('{{ $tr->id_trip_request }}')" class="dropdown-item text-danger">
                                    Reject
                                </a>
                                
                                <a onclick="confirmApprove('{{ $tr->id_trip_request }}')" class="dropdown-item text-secondary">
                                    Approve
                                </a>
                            @endif

                            {{-- Waiting GAD --}}
                            @if ($tr->status == '2')
                                <a onclick="confirmResponse('{{ $tr->id_trip_request }}')" class="dropdown-item text-primary">
                                    Response
                                </a>
                            @endif

                            {{-- Responded --}}
                            @if ($tr->status == '3')
                                @if ($tr->kendaraan == '')
                                    <a href="{{ url('/trip-pick-car') }}/{{ $tr->id_trip_request }}" class="dropdown-item text-warning">
                                       Pilih Kendaraan
                                    </a>
                                @else
                                    {{-- <a href="{{ url('/trip-ticket') }}/{{ $tr->id_trip }}" class="dropdown-item text-info">
                                        Ticket
                                    </a> --}}
                                    
                                    <a href="{{ url('/trip-check') }}/{{ $tr->id_trip }}" class="dropdown-item text-warning">
                                        Trip Check
                                    </a>
                                @endif
                            @endif

                            <a href="{{ url('/trip') }}/{{ $tr->id_trip_request }}" class="dropdown-item text-info">
                                Show
                            </a>
                        </div>
                    </td>
                    <td class="fill">{{ $tr->pemohon }}</td>
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
                </tr>
            @endforeach

            
        </tbody>
        
    </table>
</div>


<script>
    datatable();
    tooltip();
</script>