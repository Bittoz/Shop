<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    
    {{-- Stylesheets --}}
    @include('admin.stylesheet')
</head>
<body>

    {{-- Navigation/Header --}}
    @include('admin.navigation')

    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Footer Scripts --}}
    @include('admin.javascript')

</body>
</html>
