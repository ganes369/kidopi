<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 Data</title>
    <style>
        .rodape {
        background-color: #333; /* Cor de fundo do rodapé */
        color: #fff; /* Cor do texto do rodapé */
        padding: 20px;
        text-align: center;
        position: fixed; /* Fixa o rodapé na parte inferior da janela */
        left: 0;
        bottom: 0;
        width: 100%;
        }
        .w {
            width: 100%;
            height: 400px;
            overflow: auto;
        }
    </style>
</head>
<body>
<div class="content">
    <h1>Selecione um país:</h1>
    <select id="country">
        <option value="Canada">Canadá</option>
        <option value="Brazil">Brasil</option>
        <option value="Australia">Australia</option>
    </select>
    <button id="getDataBtn">Obter dados</button>
    <div id="inf"></div>
    <div class="w">
    
    <div id="dataContainer"></div>
    </div>

    <div id="rodape" class="rodape">
        <small>útlimo acesso: </small>
    </div>

    <script>
        const lastAcess = () => {
            fetch('index.php?action=getAcesso')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter os dados');
                    }
                    return response.json();
                })
                .then(data => {
                    var smallElement = document.querySelector('small');
                    smallElement.innerHTML ='Último acesso: '+ JSON.parse(data).data_hora+', '+JSON.parse(data).pais;
                })
                .catch(error => {
                    console.log(error)
                    document.getElementById('dataContainer').innerHTML = '<p>erro vei.</p>';
                });
        }
        lastAcess()
        document.getElementById('getDataBtn').addEventListener('click', function() {
            var selectedCountry = document.getElementById('country').value;

            fetch('index.php?action=getMortos&country=' + selectedCountry)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter os dados');
                    }
                    return response.json();
                })
                .then(data => {
                    var inf = document.getElementById('inf');
                    inf.innerHTML = inf.innerHTML = '<h1>' + selectedCountry + '</h1><p>Mortes: ' + data.totalMortos + '</p><p>Confirmados: ' + data.totalConfirmados + '</p><br/>';
                })
                .catch(error => {
                    document.getElementById('dataContainer').innerHTML = '<p>Erro ao obter os dados.</p>';
                });
        


            fetch('index.php?action=getData&country=' + selectedCountry)
                .then(response => {
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
                            dataContainer.innerHTML += '<p>Confirmados: ' + item.Confirmados + '</p>';
                            dataContainer.innerHTML += '<p>Mortos: ' + item.Mortos + '</p>';
                            dataContainer.innerHTML += '<hr>';
                        }
                    }
                })
                .catch(error => {
                    document.getElementById('dataContainer').innerHTML = '<p>Erro ao obter os dados.</p>';
                });
                lastAcess()
            });
    </script>
</body>
</html>
