<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 Data</title>
</head>
<body>
    <h1>Selecione um país:</h1>
    <select id="country">
        <option value="Canada">Canadá</option>
        <option value="Brazil">Brasil</option>
        <option value="Australia">Australia</option>
    </select>
    <button id="getDataBtn">Obter dados</button>

    <div id="dataContainer"></div>

    <script>
        document.getElementById('getDataBtn').addEventListener('click', function() {
            var selectedCountry = document.getElementById('country').value;
            fetch('index.php?action=getData&country=' + selectedCountry)
                .then(response => {
                    console.log(response);
                    if (!response.ok) {
                        throw new Error('Erro ao obter os dados');
                    }
                    return response.json();
                })
                .then(data => {
                    var dataContainer = document.getElementById('dataContainer');
                    dataContainer.innerHTML = '';
                    for (var key in data) {

                        if (data.hasOwnProperty(key)) {
                            var item = data[key];
                            dataContainer.innerHTML += '<p>Provincia/Estado: ' + item.ProvinciaEstado + '</p>';
                            dataContainer.innerHTML += '<p>País: ' + item.Pais + '</p>';
                            dataContainer.innerHTML += '<p>Confirmados: ' + item.Confirmados + '</p>';
                            dataContainer.innerHTML += '<p>Mortos: ' + item.Mortos + '</p>';
                            dataContainer.innerHTML += '<hr>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('dataContainer').innerHTML = '<p>Erro ao obter os dados.</p>';
                });
        });
    </script>
</body>
</html>
