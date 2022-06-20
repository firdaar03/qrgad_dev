@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div class="card show">
        <div class="card-header">
            <h3><b>Upload Asset</b></h3>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ url('/aset-import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file" class="mandatory">Choose File</label>
                        <input accept=".xlsx, .xls, .csv" name="file" id="file" type="file" class="form-control @error('file') is-invalid @enderror"
                        value="{{ old('file') }}" placeholder="Choose File">
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex float-right mt-5 mb-5">
                        <div class="d-inline mr-2">
                            <a href="{{ url('/sub-kategori-konsumable') }}" class="btn btn-secondary float-right">Batal</a>
                        </div>
                        <div class="d-inline">
                            <button type="submit" class="btn btn-primary float-right mr-3">Simpan</button>
                        </div>
                        <div class="d-inline">
                            <a type="button" href="{{ url('/aset-export') }}" class="btn btn-success float-right mr-3">Download Template</a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <script>
        mandatory();
    </script>
@endsection