function cargarCriptomonedas() {
    axios.get('/Cryptolnvestment/public/getInfo')
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
            document.getElementById('result').innerHTML = tableContent;
        })
        .catch(function (error) {
            console.error(error);
            document.getElementById('result').innerHTML = `<div class="alert alert-danger">Error al obtener los datos.</div>`;
        });
}

// Llamar inmediatamente al cargar la página
cargarCriptomonedas();

// Luego actualizar cada 30 segundos
setInterval(cargarCriptomonedas, 30000);