@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Data Asset</h4>
                </div>
                
            </div>
            
            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover dataTable" >
                        <thead class="bg-primary text-white">
                            <tr>
                                <td class="text-center">#</td>
                                <td class="text-center">Kode Asset</td>
                                <td class="text-center">Deskripsi</td>
                                <td class="text-center">Lokasi</td>
                                <td class="text-center">Kondisi</td>
                                <td class="text-center">Waktu Update</td>
                                <td class="text-center">Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aset as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->code_asset }}</td>
                                    <td>{{ $a->deskripsi }}</td>
                                    <td>{{ $a->location }}</td>
                                    <td>{{ $a->condition }}</td>
                                    <td>{{ $a->update_time }}</td>
                                    <td>{{ $a->keterangan }}</td>
                                    
                                </tr>
                            @endforeach

                            
                        </tbody>
                        
                    </table>
                </div>
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

