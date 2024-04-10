<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecione Países</title>
    <!-- Adicionando os estilos do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col">
            <label for="country1">Selecione um país 1:</label>
            <select id="country1" class="form-control">
                <!-- Opções serão preenchidas dinamicamente via JavaScript -->
            </select>
        </div>
        <div class="col">
            <label for="country2">Selecione um país 2:</label>
            <select id="country2" class="form-control">
                <!-- Opções serão preenchidas dinamicamente via JavaScript -->
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <button id="getDataBtn" class="btn btn-primary">Obter dados</button>
        </div>
    </div>
    <div id="dataContainer" class="container mt-4">
        <!-- Conteúdo será preenchido dinamicamente via JavaScript -->
    </div>
    <!-- Loader Bootstrap -->
    <div class="spinner-border text-primary" role="status" id="loader" style="display: none;">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<script>
    // Função para preencher o select com os dados retornados pela API
    function preencherSelect(data) {
        var select1 = document.getElementById("country1");
        var select2 = document.getElementById("country2");
        for (var i = 0; i < data.length; i++) {
            var option1 = document.createElement("option");
            option1.text = data[i];
            select1.appendChild(option1);

            var option2 = document.createElement("option");
            option2.text = data[i];
            select2.appendChild(option2);
        }
    }

    // Mostra a loader
    function showLoader() {
        document.getElementById("loader").style.display = "block";
    }

    // Esconde a loader
    function hideLoader() {
        document.getElementById("loader").style.display = "none";
    }

    // Fazendo uma requisição à API para obter os dados dos países
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "index.php?action=getPaises", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);
            preencherSelect(data);
        }
    };
    xhr.send();

    document.getElementById('getDataBtn').addEventListener('click', function () {
        var selectedCountry1 = document.getElementById('country1').value;
        var selectedCountry2 = document.getElementById('country2').value;

        // Limpa o conteúdo anterior da div dataContainer
        document.getElementById('dataContainer').innerHTML = '';

        // Mostra a loader ao iniciar a requisição
        showLoader();

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "index.php?action=taxa&country1=" + selectedCountry1 + "&country2=" + selectedCountry2, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                // Esconde a loader após a conclusão da requisição
                hideLoader();

                if (xhr.status == 200) {
                    var data = xhr.responseText;
                    const num = data.replaceAll(`"`, '')

                    var inf = document.getElementById('dataContainer');
                    if (Number(num) < 0) {
                        const text = `Taxa do País ${selectedCountry2} maior do que a do país ${selectedCountry1}`
                        inf.innerHTML = `${text} = <strong>${Number(num)}</strong>`;
                        return
                    } else if (Number(num) > 0) {
                        const text = `Taxa do ${selectedCountry1} maior do que a do ${selectedCountry2}`
                        inf.innerHTML = `${text} = <strong>${Number(num)}</strong>`;
                        return
                    }
                    const text = `Taxa do ${selectedCountry1} e ${selectedCountry2} são iguais`
                    inf.innerHTML = `${text} = <strong>${Number(num)}</strong>`;
                }
            }
        };
        xhr.send();
    });
</script>
</body>
</html>
