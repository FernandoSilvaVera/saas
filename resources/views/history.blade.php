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

                <!-- history_section -->
                <div class="history_section section_padding_bg">
                    <div class="container-fluid">

                        <div class="contact_top pb_20">
                            <h2>Historial</h2>
                        </div>

                        <div class="table_wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Card Number</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Erik Malmberg</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tom Plath</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>Joseph Kelley</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>Cindy Welsh</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>James Myrick</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>Tom Plath</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>Joseph Kelley</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>Cindy Welsh</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>James Myrick</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>Cindy Welsh</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                    <tr>
                                        <td>James Myrick</td>
                                        <td>XXXX-XXXX-XXXX-2582</td>
                                        <td>10/02/2020</td>
                                        <td>10/02/2024</td>
                                        <td> <a href="#" class="button">Download Again</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination_wrap d-flex justify-content-end w-100">
                            <div class="pagination d-flex align-items-center">
                                <a href="#" class="pagination_arrow">
                                    <img src="./img/arrow_left.svg" alt="">
                                </a>
                                <div class="numbers">
                                    <a href="#">Prev</a>
                                    <a href="#">1</a>
                                    <a href="#">2</a>
                                    <a href="#">3</a>
                                    <a href="#" class="active">4</a>
                                    <a href="#">5</a>
                                    <a href="#">6</a>
                                    <a href="#">7</a>
                                    <a href="#">Next</a>
                                </div>
                                <a href="#" class="pagination_arrow">
                                    <img src="./img/arrow_right.svg" alt="">
                                </a>
                            </div>
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
