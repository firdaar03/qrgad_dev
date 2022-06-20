<select name="perusahaan" id="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror">
    <option value="">-- pilih perusahaan --</option>
    @foreach ($perusahaans as $perusahaan)
        <option value="{{ $perusahaan->id }}" {{ (old('perusahaan') == $perusahaan->id )? 'selected' : '' }}>{{ $perusahaan->nama }}</option>
    @endforeach
</select>