<ul class="nav nav-primary">

    <li class="nav-item {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">
        <a href="{{ url('/dashboard') }}" class="collapsed" aria-expanded="false">
          <i class="fas fa-home"></i>
          <p>Dashboardd</p>
        </a>
    </li>
    
    @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000003" || Auth::user()->level == "LV00000004")
    
      {{-- MODUL MEETING ROOM --}}
      @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000004")
        <li class="nav-item {{ Request::is('jadwal-ruangan*') || Request::is('ruangan*') || Request::is('fasilitas') || Request::is('ruangan-report') || Request::is('lokasi')? 'active' : '' }}">
          <a data-toggle="collapse" href="#meeting-room" class="collapsed" aria-expanded="false">
            <i class="fas fa-users"></i>
            <p>Ruang Meeting</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ Request::is('jadwal-ruangan*') || Request::is('ruangan*') || Request::is('fasilitas')|| Request::is('report-ruangan') || Request::is('lokasi')? 'show' : '' }}" id="meeting-room">
            <ul class="nav nav-collapse">
              
              {{-- peminjaman ruangan --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002"|| Auth::user()->level == "LV00000004")
                <li class="{{ Request::is('jadwal-ruangan*')? 'active' : '' }}">
                  <a href="{{ url('/jadwal-ruangan') }}">
                    <span class="sub-item ">Peminjaman Ruangan</span>
                  </a>
                </li>
              @endif

              {{-- ruangan --}}
              @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                <li class="{{ Request::is('ruangan') || Request::is('ruangan/*')? 'active' : '' }}">
                  <a href="{{ url('/ruangan') }}">
                    <span class="sub-item ">Ruangan</span>
                  </a>
                </li>
              @endif
              
              {{-- fasilitas --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002")
                <li class="{{ Request::is('fasilitas')? 'active' : '' }}">
                  <a href="{{ url('/fasilitas') }}">
                    <span class="sub-item">Fasilitas</span>
                  </a>
                </li>
              @endif
              
              {{-- lokasi --}}
              @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                <li class="{{ Request::is('lokasi')? 'active' : '' }}">
                  <a href="{{ url('/lokasi') }}">
                    <span class="sub-item">Lokasi</span>
                  </a>
                </li>
              @endif
              
              {{-- report ruangan --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002")
                <li class="{{ Request::is('ruangan-report*')? 'active' : '' }}">
                  <a href="{{ url('/ruangan-report') }}">
                    <span class="sub-item ">Report Ruangan</span>
                  </a>
                </li>
              @endif

            </ul>
          </div>
        </li>
      @endif

      {{-- MODUL ASET --}}
      @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
        <li class="nav-item {{ Request::is('aset*')? 'active' : '' }}">
          <a data-toggle="collapse" href="#aset" class="collapsed" aria-expanded="false">
            <i class="fas fa-hand-holding-usd"></i>
            <p>Aset</p>
            <span class="caret"></span>
          </a>
          <div id="aset" class="collapse {{ Request::is('aset*')  || Request::is('table-aset')? 'show' : '' }}">
            <ul class="nav nav-collapse">
              
              {{-- upload aset --}}
              @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                <li class="{{ Request::is('aset/create')? 'active' : '' }}">
                  <a href="{{ url('/aset/create') }}">
                    <span class="sub-item">Upload Asset</span>
                  </a>
                </li>
              @endif
              
              {{-- aset --}}
              @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                <li class="{{ Request::is('aset')? 'active' : '' }}">
                  <a href="{{ url('/aset') }}">
                    <span class="sub-item">Tabel Asset</span>
                  </a>
                </li>
              @endif

            </ul>
          </div>
        </li>
      @endif

      {{-- MODUL KELUHAN --}}
      @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000004")
        <li class="nav-item {{ Request::is('keluhan*') || Request::is('lokasi-maintain')? 'active' : '' }}">
          <a data-toggle="collapse" href="#keluhan" class="collapsed" aria-expanded="false">
            <i class="fas fa-flag"></i>
            <p>Keluhan</p>
            <span class="caret"></span>
          </a>
          <div id="keluhan" class="collapse {{ Request::is('keluhan*') || Request::is('lokasi-maintain')? 'show' : ''  }}">
            <ul class="nav nav-collapse">
              
              {{--dashboard maintenance--}}
              @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                <li class="{{ Request::is('keluhan-dashboard*')? 'active' : '' }}">
                  <a href="{{ url('/keluhan-dashboard') }}">
                    <span class="sub-item ">Dashboard Maintenance</span>
                  </a>
                </li>
              @endif

              {{-- index maintenance --}}
              @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000004" )
                <li class="{{ Request::is('keluhan') || Request::is('keluhan/*') ? 'active' : '' }}">
                  <a href="{{ url('/keluhan') }}">
                    <span class="sub-item ">Index Maintenance</span>
                  </a>
                </li>
              @endif

              {{-- lokasi maintenance --}}
              @if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                <li class="{{ Request::is('lokasi-maintain')? 'active' : '' }}">
                  <a href="{{ url('/lokasi-maintain') }}">
                    <span class="sub-item">Lokasi Maintenance</span>
                  </a>
                </li>
              @endif

            </ul>
          </div>
        </li>
      @endif

      {{-- MODUL INVENTORY --}}
      @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
        <li class="nav-item {{ Request::is('inventory*') || Request::is('kategori-konsumable') || Request::is('sub-kategori-konsumable*') || Request::is('konsumable*')  ? 'active' : '' }}">
          <a data-toggle="collapse" href="#inventory" class="collapsed" aria-expanded="false">
            <i class="fas fa-cubes"></i>
            <p>Inventori</p>
            <span class="caret"></span>
          </a>

          <div id="inventory" class="collapse {{ Request::is('inventory*') || Request::is('kategori-konsumable') || Request::is('sub-kategori-konsumable*') || Request::is('konsumable*') ? 'show' : ''  }}">
            <ul class="nav nav-collapse">

              {{-- table inventory --}}
                @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                    <li class="{{ Request::is('inventory') || Request::is('inventory-tambah*') || Request::is('konsumable/*')? 'active' : '' }}">
                      <a href="{{ url('/inventory') }}">
                          <span class="sub-item ">Table Inventory</span>
                      </a>
                    </li>
                @endif
                
                {{-- kategori konsumable --}}
                @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                    <li class="{{ Request::is('kategori-konsumable*')? 'active' : '' }}">
                    <a href="{{ url('/kategori-konsumable') }}">
                        <span class="sub-item ">Kategori Consumable</span>
                    </a>
                    </li>
                @endif

                {{-- sub kategori konsumable --}}
                @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                    <li class="{{ Request::is('sub-kategori-konsumable*')? 'active' : '' }}">
                        <a href="{{ url('/sub-kategori-konsumable') }}">
                        <span class="sub-item ">Sub Kategori Consumable</span>
                        </a>
                    </li>
                @endif

                {{-- tambah konsumable --}}
                @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                    <li class="{{ Request::is('konsumable/create')? 'active' : '' }}">
                        <a href="{{ url('/konsumable/create') }}">
                        <span class="sub-item ">Tambah Consumable</span>
                        </a>
                    </li>
                @endif

                {{-- report inventory --}}
                @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002")
                    <li class="{{ Request::is('inventory-report*')? 'active' : '' }}">
                        <a href="{{ url('/inventory-report') }}">
                            <span class="sub-item ">Inventory Report</span>
                        </a>
                    </li>
                @endif
            </ul>
          </div>
        </li>
      @endif

      {{-- MODUL TRANSPORTATION MANAGEMENT SYSTEM --}}
      @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" || Auth::user()->level == "LV00000003" || Auth::user()->level == "LV00000004")
        <li class="nav-item {{ Request::is('kendaraan*') || Request::is('supir*') || Request::is('trip*') ? 'active' : '' }}">
          <a data-toggle="collapse" href="#tms" class="collapsed" aria-expanded="false">
            <i class="fas fa-car"></i>
            <p>TMS</p>
            <span class="caret"></span>
          </a>
          <div class="collapse {{ Request::is('kendaraan*') || Request::is('supir*') || Request::is('trip*') ? 'show' : '' }}" id="tms">
            <ul class="nav nav-collapse">

              {{-- table tms --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002"|| Auth::user()->level == "LV00000004")
                <li class="{{ Request::is('trip') || Request::is('trip-pick-car*') || Request::is('trip-ticket*') ? 'active' : '' }}">
                  <a href="{{ url('/trip') }}">
                    <span class="sub-item ">Table TMS</span>
                  </a>
                </li>
              @endif
              
              {{-- form tms --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002"|| Auth::user()->level == "LV00000004")
                <li class="{{ Request::is('trip/create')? 'active' : '' }}">
                  <a href="{{ url('/trip/create') }}">
                    <span class="sub-item ">Form TMS</span>
                  </a>
                </li>
              @endif

              {{-- check trip --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002"|| Auth::user()->level == "LV00000003")
                <li class="{{ Request::is('trip-check*')? 'active' : '' }}">
                  <a href="{{ url('/trip-check') }}">
                    <span class="sub-item ">Check Trip</span>
                  </a>
                </li>
              @endif

              {{-- kendaraan --}}
              @if (Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002" )
                <li class="{{ Request::is('kendaraan*')? 'active' : '' }}">
                  <a href="{{ url('/kendaraan') }}">
                    <span class="sub-item ">Kendaraan</span>
                  </a>
                </li>
              @endif
              
              {{-- driver --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002")
                <li class="{{ Request::is('supir*')? 'active' : '' }}">
                  <a href="{{ url('/supir') }}">
                    <span class="sub-item">Driver</span>
                  </a>
                </li>
              @endif

              {{-- jadwal TMS --}}
              @if (Auth::user()->level == "LV00000001"|| Auth::user()->level == "LV00000002")
                <li class="{{ Request::is('trip-schedule*')? 'active' : '' }}">
                  <a href="{{ url('/trip-schedule') }}">
                    <span class="sub-item ">Jadwal TMS</span>
                  </a>
                </li>
              @endif

            </ul>
          </div>
        </li>
      @endif

    @endif
  </ul>