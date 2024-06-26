<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="img/favicon.svg" type="image/png" rel="icon">

    <!-- all css here -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/helper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    </head>
<body class="antialiased">


    <div class="dashboard align-items-start">

        <!-- overlay -->
        <div class="overlay d-lg-none d-block"></div>

        <!-- sidebar -->
        <div class="sidebar">
            <a href="#" class="logo">
                <img src="./img/logo.svg" alt="">
            </a>

		@include('includes/primary_menu')

        </div>

        <!-- main_content_wrap -->
        <div class="main_content_wrap">

            <!-- main_content_header -->
            <div class="main_content_header pl_24 pr_24 pt_24 pb_24 d-flex justify-content-between w-100">
                <div class="header_left gap_24 d-flex">
                    <div class="hamburger d-lg-none d-flex">
                        <img src="./img/hamburger.svg" class="hamburger_bar" alt="">
                        <img src="./img/close.svg" class="close" alt="">
                    </div>
                </div>

            </div>

            <!-- main_content -->
            <div class="main_content pl_24 pr_24 pb_60 w-100">

                <!-- userlist_section -->
                <div class="userlist_section section_padding_bg">
                    <div class="container-fluid">

                        <div class="table_wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Plan</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
				@foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->email}}</td>
                                        <td>{{$client->subscriptionPlan->name}}</td>
                                        <td>Suscrito</td>
                                        <td><a href="{{ route('client', ['id' => $client->id]) }}" class="button">Editar</a></td>
                                    </tr>
				@endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- all js here -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>


</body>
</html>
