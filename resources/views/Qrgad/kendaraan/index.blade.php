@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Data Kendaraan</h4>
                    <a class="btn btn-primary btn-round ml-auto" href="{{ url('/kendaraan/create') }}">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="col-1 disolve">
                                <span>Tambah</span>
                            </div>
                        </div>
                    </a>
                </div>
                
            </div>
            
            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="table" class="display table table-striped table-hover dataTable" >
                        <thead class="bg-primary text-white">
                            <tr>
                                <td class="text-center">#</td>
                                <td style="text-align: center">Kendaraan</td>
                                <td style="text-align: center">Nomor Polisi</td>
                                <td style="text-align: center">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kendaraans as $k)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $k->nama }}</td>
                                    <td>{{ $k->nopol }}</td>
                                    <td style="text-align: center">
                                        <div class="form-button-action">

                                            <a href="{{ url('/kendaraan') }}/{{ $k->id }}/edit" type="button" data-toggle="tooltip" title="Edit" class="btn btn-link btn-warning btn-lg">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            
                                            <a href="" type="button" data-value="{{ $k->id }}" data-toggle="modal" data-target="#modalDelete" rel="tooltip" title="Delete" onclick="$('#modalDelete #formDelete').attr('action', '{{ url('/kendaraan/'.$k->id) }}')" class="delete-modal btn btn-lg btn-link btn-danger">
                                                <i class="fa fa-times"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal delete --}}
    <div class="modal" id="modalDelete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <form id="formDelete" action="/kendaraan" method="post" class="d-inline">
                @method('delete')
                @csrf
                <div class="modal-body" >
                    <div class="form-group">
                        <p class="mb-3">Yakin ingin menghapus data?</p>
                        <div class="inline">
                            <button class="btn btn-danger float-right" >Hapus</button>
                            <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
                        </div>
                        <br><br>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
    
@endsection

@section('script')
    
    @if (session()->has('alert'))
        @php
            $alert = session()->get('alert');
            $state = explode('-', $alert)[0];
            $action = explode('-', $alert)[1];
            $menu = explode('-', $alert)[2];
        @endphp

        <script>
            var state = @json($state);
            var action = @json($action);
            var menu = @json($menu);

            getAlert(state, action, menu);
        </script>
    @endif  
       
 @endsection    

