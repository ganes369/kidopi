
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 Data</title>
    <!-- Incluir os arquivos CSS do Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .content {
            min-height: 100%;
            padding: 100px;
            padding-bottom: 50px; /* Ajuste o espaço para o rodapé */
            box-sizing: border-box; /* Garante que o padding não aumente a altura total */
        }

        h1 {
            margin-bottom: 10px;
        }

        #country {
            width: 100%;
            margin-bottom: 10px;
        }

        .rodape {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: fixed; /* Fixa o rodapé na parte inferior da janela */
            left: 0;
            bottom: 0;
            width: 100%;
        }

        .w {
            width: 100%;
            height: calc(100% - 150px); /* Altura ajustada para o espaço restante após o cabeçalho e o rodapé */
            overflow: auto; /* Adiciona scroll se o conteúdo vazar */
        }

        #loader {
            display: none; /* Oculta o loader por padrão */
            position: fixed;
            z-index: 9999; /* Posiciona o loader acima de todos os outros elementos */
            left: 50%;
            top: 50%;
            width: 100px;
            height: 100px;
            margin-left: -50px; /* Centraliza o loader horizontalmente */
            margin-top: -50px; /* Centraliza o loader verticalmente */
            border: 16px solid #f3f3f3; /* Cinza claro */
            border-radius: 50%;
            border-top: 16px solid #3498db; /* Azul */
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Animação de rotação */
            animation: spin 2s linear infinite;
        }

        /* Animação de rotação */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="loader"></div> <!-- Elemento de carregamento -->
    <div class="content">
        <h1>Selecione um país:</h1>
        <select id="country" class="form-control">
            <option value="Canada">Canadá</option>
            <option value="Brazil">Brasil</option>
            <option value="Australia">Australia</option>
        </select>
        <button id="getDataBtn" class="btn btn-primary mt-2">Obter dados</button>
        <div id="inf" class="mt-3"></div>
        <div class="w overflow-auto">
            <div id="dataContainer"></div>
        </div>
    </div>

    <footer class="rodape bg-dark text-white py-3 fixed-bottom">
        <div class="container text-center">
            <small id="ultimoAcesso">Último acesso: </small>
        </div>
    </footer>

    <!-- Incluir os arquivos JavaScript do Bootstrap e jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const showLoader = () => {
            document.getElementById('loader').style.display = 'block';
        }

        const hideLoader = () => {
            document.getElementById('loader').style.display = 'none';
        }

        const lastAccess = () => {
            showLoader(); // Mostra o loader enquanto os dados estão sendo carregados
            fetch('index.php?action=getAcesso')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter os dados');
                    }
                    return response.json();
                })
                .then(data => {
                    var ultimoAcesso = document.getElementById('ultimoAcesso');
                    ultimoAcesso.innerHTML = 'Último acesso: ' + JSON.parse(data).data_hora + ', ' + JSON.parse(data).pais;
                    hideLoader(); // Esconde o loader após os dados serem carregados
                })
                .catch(error => {
                    console.error(error);
                    hideLoader(); // Esconde o loader em caso de erro
                    document.getElementById('dataContainer').innerHTML = '<p>Erro ao obter os dados.</p>';
                });
        }

        lastAccess();

        document.getElementById('getDataBtn').addEventListener('click', function() {
            showLoader(); // Mostra o loader enquanto os dados estão sendo carregados
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
                    inf.innerHTML = '<h1>' + selectedCountry + '</h1><p>Mortes: ' + data.totalMortos + '</p><p>Confirmados: ' + data.totalConfirmados + '</p><br/>';
                    hideLoader(); // Esconde o loader após os dados serem carregados
                })
                .catch(error => {
                    console.error(error);
                    hideLoader(); // Esconde o loader em caso de erro
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
                    hideLoader(); // Esconde o loader após os dados serem carregados
                })
                .catch(error => {
                    console.error(error);
                    hideLoader(); // Esconde o loader em caso de erro
                    document.getElementById('dataContainer').innerHTML = '<p>Erro ao obter os dados.</p>';
                });

            lastAccess();
        });
    </script>
</body>
</html>
