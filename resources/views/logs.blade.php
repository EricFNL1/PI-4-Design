<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledashboard.css">
    <title>Logs de Monitoramento</title>
    <link rel="icon" href="img/fundologin.jpg" type="image/x-icon" loading="lazy">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4 page2">
        <h1 class="text-center">Logs de Monitoramento</h1>

        <!-- Filtro por Data -->
        <form method="GET" action="{{ url('/logs') }}">
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="dataInicio" class="form-label">Data de Início</label>
                    <input type="date" name="dataInicio" id="dataInicio" class="form-control" value="{{ request('dataInicio') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="dataFim" class="form-label">Data de Fim</label>
                    <input type="date" name="dataFim" id="dataFim" class="form-control" value="{{ request('dataFim') }}" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de Logs -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Temperatura</th>
                    <th>Umidade</th>
                    <th>Umidade do Solo</th>
                </tr>
            </thead>
            <tbody id="logTableBody">
                <!-- O conteúdo será preenchido pelo JavaScript -->
            </tbody>
        </table>

        <!-- Controle de Paginação -->
        <div class="d-flex justify-content-center">
            <button onclick="prevPage()" class="btn btn-primary me-2">Anterior</button>
            <span id="pageNumber">1</span>
            <button onclick="nextPage()" class="btn btn-primary ms-2">Próxima</button>
        </div>

        <div class="text-center my-4">
            <a href="/" class="back-button">Voltar para Home</a>
        </div>
    </div>

    <script>
        // Dados simulados para fins de demonstração
        const logs = @json($logs);

        const itemsPerPage = 5; // Número de registros por página
        let currentPage = 1;

        function renderTable() {
            const logTableBody = document.getElementById('logTableBody');
            logTableBody.innerHTML = '';

            // Calcula o índice de início e fim para a página atual
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedItems = logs.slice(start, end);

            // Popula a tabela com os registros da página atual
            paginatedItems.forEach(log => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${log.created_at ? new Date(log.created_at).toLocaleDateString() : 'Sem data'}</td>
                    <td>${log.created_at ? new Date(log.created_at).toLocaleTimeString() : 'Sem hora'}</td>
                    <td>${log.temperature ?? 'N/A'} °C</td>
                    <td>${log.humidity ?? 'N/A'} %</td>
                    <td>${log.soil_moisture ?? 'N/A'} %</td>
                `;
                logTableBody.appendChild(row);
            });

            // Atualiza o número da página
            document.getElementById('pageNumber').textContent = currentPage;
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        }

        function nextPage() {
            if (currentPage * itemsPerPage < logs.length) {
                currentPage++;
                renderTable();
            }
        }

        // Inicializa a tabela na primeira página
        document.addEventListener('DOMContentLoaded', renderTable);
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
