<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CryptoInvestment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <!--Estilos desde el archivo css -->
    <link rel="stylesheet" href="../css/app.css" />
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center mb-5">Cotización actual de Criptomonedas</h1>

        <!--Sección de precioss-->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">Precios en tiempo real</h4>
                <div id="tablaCriptos" class="table-responsive"></div>
                <canvas id="priceChart" height="200"></canvas>
            </div>
        </div>

        <!--Sección de busqueda-->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">Buscar información de Criptomoneda</h4>
                <div class="input-group mb-3">
                    <input type="text" id="txtIdCripto" name="txtIdCripto" class="form-control"
                        placeholder="Ingrese el id de la criptomoneda" />
                    <button onclick="buscarInformacionCripto()" class="btn btn-primary" type="button">Buscar</button>
                </div>
                <div id="info"></div>
                <div id="result" class="mt-3"></div>

            </div>
        </div>

        <!--Sección de histórico -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Historico de precios criptomoneda</h4>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="fechaDesde" class="form-label">Desde:</label>
                        <input type="date" id="fechaDesde" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label for="fechaHasta" class="form-label">Hasta:</label>
                        <input type="date" id="fechaHasta" class="form-control" />
                    </div>
                </div>

                <div id="crypto-table" class="table-responsive">Cargando datos...</div>
            </div>
        </div>
    </div>

    <!--Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../js/crypto.js"></script>
</body>

</html>
