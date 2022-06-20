@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card shadow">
        <div class="">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="mr-3">Report Inventory</h4>
                </div>
                
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <form action="{{ url('/inventory-report') }}" method="GET">
                            <div class="form-group">
                                <label for="start_date">Tanggal Awal</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end_date">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-auto align-self-end">
                            <div class="form-group ">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-auto align-self-end">
                        <div class="form-group ">
                            <button class="btn btn-primary btn-border dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Print</button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(126px, 43px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" onclick="exportExcel()" href="#">Excel</a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" onclick="exportPdf()" href="#">PDF</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="table-responsive">
                        <table id="report-table" class="display table table-striped table-hover dataTable" >
                            <thead class="bg-primary text-white">
                                <tr>
                                    <td class="text-center">#</td>
                                    <td style="text-align: center">Kode Konsumable</td>
                                    <td style="text-align: center">Nama Konsumable</td>
                                    <td style="text-align: center">Kategori</td>
                                    <td style="text-align: center">Sub Kategori</td>
                                    <td style="text-align: center">Stock</td>
                                    <td style="text-align: center">Last Entry</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tabelinventory as $ti)
                                    <tr>
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td style="text-align: center" >{{ $ti->id_konsumable }}</td>
                                        <td>{{ $ti->nama_konsumable }}</td>
                                        <td>{{ $ti->kategori_konsumable }}</td>
                                        <td>{{ $ti->sub_kategori_konsumable }}</td>
                                        <td style="text-align: center">
                                            @if ($ti->stock == "")
                                                 <span class="badge badge-danger">0 {{ $ti->satuan }}</span>
                                            @else
                                                @if ($ti->stock <= $ti->minimal_stock)
                                                    <span class="badge badge-danger"> {{ $ti->stock }} {{ $ti->satuan }} </span>
                                                @else
                                                    <span class="badge badge-success"> {{ $ti->stock }} {{ $ti->satuan }} </span>
                                                @endif
                                            @endif
                                            
                                        </td>
                                        <td style="text-align: center">{{ $ti->last_entry }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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

        $(document).ready(function() {  
            $('#report-table').DataTable({
                dom: "frtip",
                buttons: [
                    {
                        text: 'excel',
                        extend: 'excelHtml5',
                        type: 'hidden',
                    },
                    {
                        text: 'pdf',
                        extend: 'pdfHtml5',
                    }, 
                ],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });
        });

        function exportPdf(){
            var table = $('#report-table').DataTable();
            table.button('.buttons-pdf').trigger();
        }

        function exportExcel(){
            var table = $('#report-table').DataTable();
            table.button('.buttons-excel').trigger();
        }

        // datatableReport();
        // exportExcel();
        // exportPdf();

        $(function () {
                $("[rel='tooltip']").tooltip();
        });
    </script>
 @endsection    

