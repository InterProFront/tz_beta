<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тех Задание</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="/js/lib/vue.js"></script>
    <script src="/js/lib/vue-resource.js"></script>
    <script src="/js/lib/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>
    <div class="wrapper">
        @include('front.header')

        @yield('content')

        {{--@include('front.footer')--}}
    </div>


    @yield('scripts')
    {{--<script src="/js/addproject.js"></script>--}}
    {{--<script src="/js/addpage.js"></script>--}}
</body>
</html>