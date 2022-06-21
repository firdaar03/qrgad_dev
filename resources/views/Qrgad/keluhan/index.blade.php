@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Data Keluhan</h4>
                    <a class="btn btn-primary btn-round ml-auto" href="{{ url('/keluhan/create') }}">
                        <div class="row">
                            <div class="col-1">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="col-1 disolve">
                                <span>Lapor Keluhan</span>
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
                                <td>Informasi Keluhan</td>
                                <td>Lokasi</td>
                                <td class="text-center">Waktu</td>
                                <td class="text-center">Status</td>
                                <td class="text-center">Aksi</td>                                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keluhan as $k)
                                <tr>
                                    {{-- {{ dd($k) }} --}}
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fill">{{ $k->keluhan }}</td>
                                    <td class="fit">{{ $k->lokasi.' ('.$k->detail_lokasi.')' }}</td>
                                    <td class="fit">{{ date("d M Y H:i",strtotime($k->input_time)) }}</td>
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

