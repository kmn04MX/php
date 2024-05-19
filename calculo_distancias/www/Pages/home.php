<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Comisiones nombreBanco</title>
    <link href="../Public/Assets/css/virtual-select.min.css" rel="stylesheet" />
    <link href="../Public/Assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- JQuery Toastr -->
    <link rel="stylesheet" href="../Js/toastr/toastr.min.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="./home.php">MAWDY</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <!-- Menu desplegable del usuario lado superior derecho -->
                    <li><a class="dropdown-item" href="#!">Configuracion</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <button id="cerrar_sesion" class="dropdown-item">Cerrar Sesion</button>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- Inicio div princiapl -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link collapsed" href="home.php" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            Home
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                    </div>
                </div>

            </nav>
        </div>
        <!-- Div central -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="mt-4"></div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Calculo de distancias
                        </div>
                        <div class="container-fluid px-4">
                            <div id="datos_anios" class="d-flex flex-sm-wrap justify-content-evenly card-body">
                                <div>
                                    <h3>Selecciona el archivo de excel a calcular</h3>
                                    <input type="file" name="file" id="file-1" class="form-control" accept=".xls,.xlsx"><br><br>
                                    <button id="submit" name="import" class="btn btn-danger mb-2">calcular y descargar <i class="fa-solid fa-file-arrow-up"></i></button>
                                    <div id="response" class="error" style="display: none;"></div>
                                </div>
                                <div class="col-md-12 text-center mt-5">
                                    <p id="mensajeL" style="font-size: 12px; font-weight: 900; display: none;">Calcundo...</p>
                                    <span id="loaderFiltro"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Mawdy &copy; 2023 Todos los derechos reservados</div>
                        <div>
                            <!--<a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>-->
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Fin div princiapl -->

    <!-- JQuery -->
    <script src="../Js/jquery/jquery.min.js"></script>
    <!-- Bootstarp -->
    <script src="../Public/Assets/bootsatrp/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    <script type="text/javascript" src="../Js/excel.js"></script>
    <script type="text/javascript" src="../Js/scripts.js"></script>

    <!-- JQuery Complementos -->
    <script type="text/javascript" src="../Js/materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="../Js/toastr/toastr.min.js"></script>
</body>

</html>