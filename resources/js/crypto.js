function cargarCriptomonedas() {

    var dataPriceTable = document.getElementById(dataPrice);

    axios.get('/Cryptolnvestment/public/getPrice')
        .then(function (response) {
            var data = response.data;

            var tableContent = `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Símbolo</th>
                            <th>Precio (USD)</th>
                            <th>Cambio en 24h (%)</th>
                            <th>Volumen en 24h (USD)</th>
                        </tr>
                    </thead>
                    <tbody>`;

            data.forEach(function(crypto) {
                tableContent += `
                    <tr>
                        <td>${crypto.name}</td>
                        <td>${crypto.symbol}</td>
                        <td>$${crypto.price_usd.toFixed(2)}</td>
                        <td>${crypto.percent_change_24h.toFixed(2)}%</td>
                        <td>$${crypto.volume_24h.toFixed(2)}</td>
                    </tr>`;
            });

            tableContent += `</tbody></table>`;
            document.getElementById('dataPrice').innerHTML = tableContent;
        })
        .catch(function (error) {
            console.error(error);
            document.getElementById('result').innerHTML = `<div class="alert alert-danger">Error al obtener los datos.</div>`;
        });
}


function buscarInformacionCripto(){

    var symbol = document.getElementById("txtIdCripto").value.trim().toUpperCase();

    if (!symbol) {
        alert("Por favor, ingrese un símbolo de criptomoneda (ej. BTC, ETH)");
        return;
    }

    axios.get('/Cryptolnvestment/public/getInfo', {
        params: { symbol: symbol }
    })
    .then(function (response){
        var data = response.data; // CORREGIDO
    
        console.log(response.data);
        var tableContent = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Simbolo</th>
                    <th>Website</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${data.category}</td>
                    <td>${data.description}</td>
                    <td>${data.date_added}</td>
                    <td>${data.name}</td>
                    <td>${data.symbol}</td>
                    <td><a href="${data.website}" target="_blank">${data.website}</a></td>
                </tr>
            </tbody>
        </table>`;
        
    
        tableContent += `</tbody></table>`;
        document.getElementById('info').innerHTML = tableContent;
    })
    .catch(error => {
        console.error(error);

        document.getElementById('result').innerHTML = `
        <div class="alert alert-danger">No se encontraron datos para el id: "${symbol}".</div>`;

    });
}

// Llamar inmediatamente al cargar la página
cargarCriptomonedas();

//buscarInformacionCripto();

// Luego actualizar cada 30 segundos
//setInterval(cargarCriptomonedas, 30000);