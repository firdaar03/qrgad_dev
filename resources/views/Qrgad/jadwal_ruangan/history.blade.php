@extends('Qrgad/layout/qrgad-admin')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <div class="d-flex">
            <h4 class="mr-3 fw-bold">History Meeting Room</h4>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs nav-line nav-fill" id="myTab" role="tablist">
            <li class="nav-item " role="presentation"  >
              <button class="nav-link active mx-auto btn-block" id="aktif-tab" data-toggle="tab" data-target="#aktif" type="button" role="tab" aria-controls="aktif" aria-selected="true">Aktif</button>
            </li>
            <li class="nav-item" role="presentation" >
              <button class="nav-link btn-block" id="riwayat-tab" data-toggle="tab" data-target="#riwayat" type="button" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
                <div class="mt-5">
                    <div class="table-responsive">
                        <table id="table" class="display table table-striped table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="fit">#</th>
                                    <th>Agenda</th>
                                    <th>Ruangan</th>
                                    <th>Waktu Peminjaman</th>
                                    <th class="text-center fit">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwals as $j)
                                    @if ($j->end >= date('Y-m-d H:i:s'))
                                        
                                        <tr>
                                            <td class="fit">{{ $loop->iteration }}</td>
                                            <td >{{ $j->agenda }}</td>
                                            <td>{{ $j->ruangan }}</td>
                                            <td class="fill" >
                                                @if (date("Y-m-d",strtotime($j->start)) == date("Y-m-d",strtotime($j->end)))
                                                    {{ date("d M Y H:i",strtotime($j->start)) }} - {{ date("H:i",strtotime($j->end)) }}
                                                @else
                                                    {{ date("d M Y H:i",strtotime($j->start)) }} - {{ date("d M Y H:i",strtotime($j->end)) }}
                                                @endif
                                            </td>
                                            <td class="align-content-center fit">
                                                <div class="form-button-action">
                                                    <a onclick="getTicket('{{ $j->id }}')" type="button" data-toggle="tooltip" title="Show" class="btn btn-link btn-info btn-lg" >
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/jadwal-ruangan') }}" class="btn btn-secondary float-right">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                <div class="mt-5">
                    <div class="table-responsive">
                        <table id="table1" class="display table table-striped table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="fit">#</th>
                                    <th>Agenda</th>
                                    <th>Ruangan</th>
                                    <th>Waktu Peminjaman</th>
                                    <th class="text-center fit">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwals as $j)
                                    @if ($j->end < date('Y-m-d H:i:s'))
                                        
                                        <tr>
                                            <td class="fit">{{ $loop->iteration }}</td>
                                            <td >{{ $j->agenda }}</td>
                                            <td>{{ $j->ruangan }}</td>
                                            <td class="fill" >
                                                @if (date("Y-m-d",strtotime($j->start)) == date("Y-m-d",strtotime($j->end)))
                                                    {{ date("d M Y H:i",strtotime($j->start)) }} - {{ date("H:i",strtotime($j->end)) }}
                                                @else
                                                    {{ date("d M Y H:i",strtotime($j->start)) }} - {{ date("d M Y H:i",strtotime($j->end)) }}
                                                @endif
                                            </td>
                                            <td class="align-content-center fit">
                                                <div class="form-button-action">
                                                    <a onclick="getTicket('{{ $j->id }}')" type="button" data-toggle="tooltip" title="Show" class="btn btn-link btn-info btn-lg">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/jadwal-ruangan') }}" class="btn btn-secondary float-right">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

{{-- modal --}}
<div class="modal" id="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content ">
        {{-- CRUD Page by Ajax --}}
      </div>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     $('#table1').DataTable({});
    // });

    function getTicket(id){
        $.get("{{ url('/jadwal-ruangan-ticket') }}/"+id, {}, function(data, status){
            $('.modal-content').html(data);
            $('#modal').modal('show');
        }) 
    }
</script>


@endsection


