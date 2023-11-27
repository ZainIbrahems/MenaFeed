<footer class="app-footer">
    <div class="site-footer-right">
        {{--@php $version = Voyager::getVersion(); @endphp--}}
        {{--@if (!empty($version))--}}
        {{--- {{ $version }}--}}
        {{--@endif--}}
        <label>Developed by <a target="_blank" href="https://www.instagram.com/nimer__alkhatib"><b>Nimer ALkhatib</b></a></label>
        @if(!\Session::has('lang') || \Session::get('lang')=='ar')
            <a style="margin: 0 10px;padding: 0;" href="{{route('change-lang')}}/en">
                <img src="{{asset('flags')}}/en.png" width="25px">
            </a>
        @else
            <a style="margin: 0 10px;padding: 0;" href="{{route('change-lang')}}/ar">
                <img src="{{asset('flags')}}/ar.png" width="25px">
            </a>
        @endif
    </div>
</footer>
