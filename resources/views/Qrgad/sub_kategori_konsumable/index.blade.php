@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Data Sub Kategori Konsumable</h4>
                    <a class="btn btn-primary btn-round ml-auto" href="{{ url('/sub-kategori-konsumable/create') }}">
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
                    <table id="basic-datatables" class="display table table-striped table-hover dataTable" >
                        <thead class="bg-primary text-white">
                            <tr>
                                <td class="text-center">#</td>
                                <td style="text-align: center">Kategori</td>
                                <td style="text-align: center">Sub Kategori</td>
                                <td style="text-align: center">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subkategori as $sk)
                                <tr>
                                    {{-- {{ dd($sk); }} --}}
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $sk->kategori_konsumable }}</td>
                                    <td>{{ $sk->nama }}</td>
                                    <td style="text-align: center">
                                        <div class="form-button-action">

                                            <a href="{{ url('/sub-kategori-konsumable') }}/{{ $sk->id }}/edit" type="button" data-toggle="tooltip" rel="tooltip" title="Edit" class="btn btn-link btn-warning btn-lg">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="" type="button" data-value="{{ $sk->id }}" data-toggle="modal" rel="tooltip" title="Delete" data-target="#modalDelete" onclick="$('#modalDelete #formDelete').attr('action', '{{ url('/sub-kategori-konsumable/'.$sk->id ) }}')" class="delete-modal btn btn-link btn-warning btn-lg btn-link btn-danger">
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
            
            <form id="formDelete" action="" method="post" class="d-inline">
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

    <script>

        $(document).ready(function() {
            $('#basic-datatables').DataTable({
            });
        });
        $(function () {
            $("[rel='tooltip']").tooltip();
    });
    </script>
@endsection    

