@extends('Qrgad/layout/qrgad-admin')

@section('content')

  {{-- modal --}}
  <div class="modal" id="myModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content" data-background-color="bg3">
        <div id="body" >
        </div>
      </div>
    </div>
  </div>

  {{-- main content --}}
  <div id="alert" class="mb-2"></div>
  <div class="card shadow">
      <div class="">
          <div class="card-header">
              <div class="d-flex">
                  <h4 class="mr-3 fw-bold">Meeting Room</h4>
                  <a class="btn btn-primary btn-round ml-auto" href="{{ url('/jadwal-ruangan-history') }}">
                    <div class="row">
                        <div class="col-1">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="col-1 disolve">
                            <span>Riwayat</span>
                        </div>
                    </div>
                </a>
              </div>
          </div>
          <div class="">
              <div class="card-body">
                <div class="mb-3">
                  <span><i class="fas fa-info-circle"></i> Tekan tanggal yang diinginkan untuk melihat detail meeting room dan melakukan peminjaman</span>
                </div>
                <div id="calendar"></div>
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

      var jadwals = @json($jadwals); //get semua data jadwal ruangan
   
       /* initialize the calendar
        -----------------------------------------------------------------*/
       //Date for the calendar events (dummy data)
       var date = new Date()
       var d    = date.getDate(),
           m    = date.getMonth(),
           y    = date.getFullYear()
   
       var Calendar = FullCalendar.Calendar;
       var Draggable = FullCalendar.Draggable;
   
       var containerEl = document.getElementById('external-events');
       var checkbox = document.getElementById('drop-remove');
       var calendarEl = document.getElementById('calendar');
   
       var calendar = new Calendar(calendarEl, {
         height : get_height(),
         expandRows: true,
         headerToolbar: {
           left: 'title',
           center  : '',
           right : 'prev next'
         },
         themeSystem: 'solar',
        //  locale: 'id',
         events: jadwals, 
         eventDisplay : 'block',
         displayEventEnd : true,
         eventTimeFormat: { // like '14:30'
           hour: 'numeric',
           minute: '2-digit',
           meridiem: 'short'
         },
         slotLabelFormat:  [
           { hour: 'numeric', minute: '2-digit',meridiem: 'short'  }, // top level of text
           { weekday: 'short' } // lower level of text
         ],
         allDaySlot: false,
         dateClick: function(info) {
            const formatYmd = date => date.toISOString().slice(0, 10);

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
              type:'get',
              url: "{{ url('/jadwal-ruangan-get-by-day') }}",
              data : 'date='+info.dateStr,
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
         },
       });
   
       calendar.render();

       function get_height() {
            return $(window).height();
      }
      
   </script>

@endsection