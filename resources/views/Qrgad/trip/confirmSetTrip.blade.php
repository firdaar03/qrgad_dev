<div class="modal-header">
    <h5 class="modal-title">
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    {{-- {{ $trips }} --}}
    @if ($trips != '[]' && $trips != '' )
        <div class="card shadow">
            <h5 class="card-header fw-bold">
                Jadwal Perjalan {{ $kendaraan->nama.' ('.$kendaraan->nopol.')' }}
            </h5>    
            <div class="card-body">
                @foreach ($trips as $t)
                    <div class="card my-2">
                        <div class="d-flex align-items-center">
                            <div class="my-auto ml-3">
                                <span class="stamp stamp-sm bg-warning"></span>
                            </div>
                            <div class="container my-2">
                                <div class="d-flex">
                                    <div class="d-flex flex-column">
                                        <small class="fw-bold">
        
                                            {{ date("d M Y H:i",strtotime($t->departure_time)) }}
                                            @if ($t->waktu_pulang != '' || $t->waktu_pulang != null)
                                                <span class="fw-bold"> - </span>
                                                {{ date("d M Y H:i",strtotime($t->waktu_pulang))." (Round Trip)" }}
                                            @else
                                                {{ " (One Way)" }}
                                            @endif
                                        
                                        </small>
                                        
                                        <small class="fw-light">{{ $t->tujuan.', '.$t->wilayah }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- <hr> --}}
    @endif

    <div class="card shadow">
        <h5 class="card-header fw-bold">
            Set Trip ({{ $trip->id_trip }})
        </h5>
        <div class="card-body">
            <div class="form-group">
                <label for="id_trip" class="mandatory">Kode Trip</label>
                <input id="id_trip" type="text" class="form-control" disabled value="{{ $trip->id_trip }}">
                <input id="kendaraan" type="text" class="form-control" hidden value="{{ $kendaraan != ''? $kendaraan->id : ''}}">
            </div>
        
           @if ($kendaraan != '') 
            <div class="d-flex">
                <div class="form-group">
                    <label for="" class="mandatory">Kendaraan</label>
                    <input type="text" class="form-control" disabled value="{{ $kendaraan->nama }}">
                </div>
                <div class="form-group">
                    <label for="nopol" class="mandatory">No Polisi</label>
                    <input type="text" class="form-control" disabled value="{{ $kendaraan->nopol }}">
                </div>
            </div>
           @endif
        
            @if ($kendaraan != '')    
                <div class="form-group" id="supir_container">
                    <label for="supir">Supir</label>
                    <select id="supir" name="supir" class="form-control">
                        <option value="">-- pilih supir --</option>
                        @foreach ($supirs as $supir)
                            <option value="{{ $supir->id }}">
                                {{ $supir->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="message_supir">Wajib diisi</div>
                </div>
            @endif
        
            @if ($kendaraan == '')
                <div class="form-group" id="voucher_container">
                    <div class="row">
                        <div class="col">
                            <label for="kode_voucher[]">Kode Voucher</label>
                            <input type="text" name ="kode_voucher[]" class="form-control" placeholder="Kode Voucher">
                        </div>
                        <div class="col">
                            <label for="kode_voucher[]">Kode Voucher</label>
                            <input type="text" name ="kode_voucher[]" class="form-control" placeholder="Kode Voucher">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="kode_voucher[]">Kode Voucher</label>
                            <input type="text" name ="kode_voucher[]" class="form-control" placeholder="Kode Voucher">
                        </div>
                        <div class="col">
                            <label for="kode_voucher[]">Kode Voucher</label>
                            <input type="text" name ="kode_voucher[]" class="form-control" placeholder="Kode Voucher">
                        </div>
                    </div>
                </div>
            @endif
        
            <div class="form-group">
                <label for="departure_time" class="mandatory">Berangkat</label>
                <input type="datetime-local" id ="departure_time" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}" name ="departure_time" min="{{ date('Y-m-d\TH:i:s', strtotime($trip->waktu_berangkat)) }}" value="" class="form-control form-time-picker">
                <div id="message_departure_time" class="invalid-feedback">Wajib Diisi</div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <div class="inline">
        <button class="btn btn-success float-right" onclick="setTrip('{{ $trip->id_trip }}')">Submit</button>
        <button class="btn btn-secondary float-right mr-1" data-dismiss="modal">Batal</button>
    </div>
</div>

<script>
    mandatory();
</script>