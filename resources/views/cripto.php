<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CryptoInvestment - Cotizaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Cotización Actual de Criptomonedas</h1>

        <!--Tabla de las criptomonedass -->
        <div id="tablaCriptos"></div>

        <!-- Aquí se muestra el grafico-->
        <canvas id="priceChart" width="600" height="300"></canvas>

        <div id="result" class="mt-4"></div>
    </div>

    <div>
        <div>
            <input placeholder="Ingrese el dato a buscar" id="txtIdCripto" name="txtIdCripto"></input>

            <button onclick="buscarInformacionCripto()" name="btnBuscar">Buscar</button>

            <div id="info">

            </div>
        </div>
    </div>




    <div>
        <label for="filterDate">Filtrar por fecha:</label>
        <label for="fromDate">Desde:</label>
        <input type="date" id="fechaDesde">

        <label for="toDate">Hasta:</label>
        <input type="date" id="fechaHasta">
        <div>
            <div id="crypto-table">Cargando datos...</div>
        </div>
    </div>


    <!--Se agrega el script de Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="../js/crypto.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        historico();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>