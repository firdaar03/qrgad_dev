@if ($breadcrumbs != null || $breadcrumbs != [])
    <h3 class="page-title">{{ end($breadcrumbs)['nama'] }}</h3>

    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="/dashboard">
                <i class="flaticon-home"></i>
            </a>
        </li>
        
        @foreach ($breadcrumbs as $bc)
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="{{ url($bc['url']) }}">{{ $bc['nama'] }}</a>
            </li>
        @endforeach
    </ul>
@endif