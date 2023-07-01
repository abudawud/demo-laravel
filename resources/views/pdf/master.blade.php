<html>

<head>
    <style>
        html,
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 70px;
        }

        div.head-title {
            padding: 5px;
            background: #00b300;
            text-align: center;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid;
        }

        header,
        footer {
            position: fixed;
            left: 0px;
            right: 0px;
        }

        header {
            height: 60px;
            margin-top: -110px;
        }

        footer {
            bottom: 0px;
            height: 50px;
            margin-bottom: -55px;
            border-top: 1px solid;
            color: gray;
            font-size: 10pt;
            padding-top: 5px;
            font-style: italic;
        }


        table.table-bordered,
        table.table-bordered td,
        th {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 2px;
        }

        .bg-orange {
            background-color: #fbebd9;
        }

        .bg-yellow {
            background-color: #ffff88;
        }

        .bg-gray {
            background-color: #eeeeee;
        }

        .br-1 {
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bolder;
        }

        .border {
            border: 1px solid;
        }

        .checklist {
            background-image: url('{{ asset("assets/img/check.png") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .page-break {
            page-break-after: always;
        }

        .font-sm {
            font-size: 0.8em;
        }

        .font-xs {
            font-size: 0.6em;
        }
    </style>
    @stack('css')
    @yield('css')
</head>

<body>
    <header>
        @include('pdf.partial.header-default')
    </header>
    <footer>
        @include('pdf.partial.footer-default')
    </footer>
    <main>
        @yield('content')
    </main>
</body>

</html>
