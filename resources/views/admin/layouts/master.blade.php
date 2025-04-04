@include('admin.includes.header')
<body data-topbar="light" data-layout="horizontal">
    <div id="layout-wrapper">
        @include('admin.includes.topbar')
        @include('admin.includes.topnav')
        <div class="main-content">
            @yield('content')
            @include('admin.includes.footer')
        </div>
    </div>
    
    @include('admin.includes.rightbar')
    @include('admin.includes.script')
    @yield('js')
</body>

</html>