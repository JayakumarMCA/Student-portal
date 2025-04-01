<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ isset($page_title) && $page_title ? $page_title : "Tech Data || Tech Data" }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Tech Data" name="description" />
        <meta content="Tech Data" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
        @include('auth.includes.style')
        @yield('css')
    </head>