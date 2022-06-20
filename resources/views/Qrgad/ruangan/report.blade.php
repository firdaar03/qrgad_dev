@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Data Ruangan</h4>
                </div>
            </div>
            
            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="table" class="display table table-striped table-hover dataTable" >
                        <thead class="bg-primary text-white">
                            <tr>
                                <td class="text-center">#</td>
                                <td style="text-align: center">Ruangan</td>
                                <td style="text-align: center">Lokasi</td>
                                <td style="text-align: center">Lantai</td>
                                <td style="text-align: center">Kapasitas</td>
                                <td style="text-align: center">Status</td>
                                <td style="text-align: center">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ruangan as $r)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $r->nama_ruang }}</td>
                                    <td>{{ $r->nama_lokasi }}</td>
                                    <td style="text-align: center" >{{ $r->lantai }}</td>
                                    <td style="text-align: center" >{{ $r->kapasitas }}</td>
                                    @if ($r->available == 1)
                                        <td style="text-align: center" >Not Available</td>
                                    @else
                                        <td style="text-align: center" >Available</td>
                                    @endif
                                    <td style="text-align: center">
                                        <div class="form-button-action">
                                            <a onclick="detilRuangan( '{{ $r->id_ruang }}' )" type="button" data-toggle='tooltip' title="Show" class="btn btn-link btn-success btn-lg">
                                                <i class="fa fa-eye"></i>
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
    
  {{-- modal --}}
  <div class="modal" id="myModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content" data-background-color="bg3">
        <div id="body" >
        </div>
      </div>
    </div>
  </div>
  
@endsection

@section('script')
    
    @if (session()->has('data'))
        @php
            $data = session()->get('data');
            $state = explode('-', $data['alert'])[0];
            $action = explode('-', $data['alert'])[1];
            $menu = explode('-', $data['alert'])[2];
        @endphp

        <script>
            var state = @json($state);
            var action = @json($action);
            var menu = @json($menu);

            getAlert(state, action, menu);
        </script>
    @endif

       <script>
            function detilRuangan(id){

                $.ajax({
                type:'get',
                url: "{{ url('/ruangan-get-by-day') }}/"+id,
                data : 'id='+id,
                success:function(data){
                    $('#body').html(data);
                    $('#myModal').modal('show');
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    $('.close').click();
                    // showAlert('danger', 'Gagal menambahkan data');
                }
                });
            }
       </script>
   
 @endsection    

