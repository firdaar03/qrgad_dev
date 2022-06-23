<div class="table-responsive">
    <table id="table" class="display table table-striped table-hover dataTable" >
        <thead class="bg-primary text-white">
            <tr>
                <td class="text-center">#</td>
                <td>Peminjam</td>
                <td>Kendaraan</td>
                <td>Driver</td>
                <td>Plan Keberangkatan</td>
                <td>Keberangkatan Aktual</td>
                <td>Status</td>
                <td class="text-center">Aksi</td>                                               
            </tr>
        </thead>
        <tbody>
            @foreach ($trip as $tr)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="fit">{{ $tr->pemohon }}</td>
                    <td class="fit">{{ $tr->kendaraan }}</td>
                    <td class="fit">{{ $tr->supir }}</td>
                    <td class="fill">{{ date("d M Y H:i",strtotime($tr->waktu_berangkat)) }}</td>
                    <td class="fill">
                        @php
                            if($tr->waktu_berangkat_aktual != ''){
                                $datetime1 = date_create($tr->waktu_berangkat);
                                $datetime2 = date_create($tr->waktu_berangkat_aktual);
                                
                                $diff = date_diff($datetime1, $datetime2);
                                
                                $interval = $diff->format('%R%h.%i ');
                                echo date("d M Y H:i",strtotime($tr->waktu_berangkat_aktual))." (".$interval.")";
                            } else {
                                echo '-';
                            }
                        @endphp
                    </td>
                    <td class="fit">
                        @php 
                            if ($tr->waktu_berangkat_aktual != '' && $tr->waktu_pulang_aktual != ''){
                                echo "<div class='badge badge-success'> Sudah Pulang </div>" ;
                            } elseif ($tr->waktu_berangkat_aktual != '' && $tr->waktu_pulang_aktual == ''){
                                echo "<div class='badge badge-primary'> Sudah Berangkat </div>" ;
                            } elseif ($tr->waktu_berangkat_aktual == '' && $tr->waktu_pulang_aktual == ''){
                                echo "<div class='badge badge-warning'> Belum Berangkat </div>" ;
                            }
                        @endphp
                    </td>
                    <td class="text-center">
                        <div class="form-button-action">
                            {{-- ubah aksi --}}
                            <a href="{{ url('/trip-schedule/'.$tr->id_trip) }}" type="button" data-toggle="tooltip" rel="tooltip" title="Show" class="btn btn-link btn-info btn-lg">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{ url('/trip-check/'.$tr->id_trip) }}" type="button" data-toggle="tooltip" rel="tooltip" title="Check Trip" class="btn btn-link btn-warning btn-lg">
                                <i class="fas fa-exchange-alt"></i>
                            </a>
                            @if ($tr->status == '3')
                                @if ($tr->kendaraan != '')
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