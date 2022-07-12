@extends('Qrgad/layout/qrgad-admin')

@section('content')
    <div id="reader" class="h-auto" style="height: 100%"></div>
    
@endsection

@section('script')
    <script>
        var value = '';
        let config = {
            fps: 10,
            qrbox: 500,
            rememberLastUsedCamera: true,
            
            // aspectRatio: 1.7777778,
            // Only support camera scan type.
            // supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
        };

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", config, true);

       function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            // console.log(`Scan result: ${decodedText}`, decodedResult);
            // alert(decodedText);
            // window.location.replace("{{ url('trip-check/') }}"+ "/" + decodedText);
            
            checkIdTrip(decodedText);
            
        }

        function onScanError(errorMessage) {
            // handle on error condition, with error message
            // console.log(`Scan error:` + errorMessage);
        }
        
        html5QrcodeScanner.render(onScanSuccess, onScanError);


        var value = '';

        function checkIdTrip(id){
            $.ajax({
                type:"get",
                url:"{{ url('/trip-check-id-trip') }}/"+id,
                success:function(data){
                    if (data){
                        window.location.replace("{{ url('trip-check/') }}"+ "/" + id);
                        html5QrcodeScanner.clear();
                    } else { 
                        // showAlert('danger', 'Scan QR', 'Gagal scan QR, gunakan QR code yang valid!');
                        if(value == '' || value != id){
                            value = id;
                            showAlert('danger', 'Scan QR', 'Gagal scan QR, gunakan QR code yang valid!');
                        }
                    }
                },error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    // alert(err.Message);
                    if(value == '' || value != id){
                        value = id;
                        showAlert('danger', 'Scan QR', 'Gagal scan QR, gunakan QR code yang valid!');
                    }
                    // html5QrcodeScanner.pause();
                }
            });
        }

    </script>
@endsection