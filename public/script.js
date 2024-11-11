// Verifica o estado do tema salvo no localStorage
document.addEventListener('DOMContentLoaded', function () {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
        document.querySelectorAll('#themeToggle, .dropdown-item[data-action="themeToggle"]').forEach(item => {
            item.classList.add('dark');
        });
    }
});

// Alternar Tema e salvar no localStorage
document.querySelectorAll('#themeToggle, .dropdown-item[data-action="themeToggle"]').forEach(item => {
    item.addEventListener('click', function () {
        const isDarkTheme = document.body.classList.toggle('dark-theme');
        document.querySelectorAll('#themeToggle, .dropdown-item[data-action="themeToggle"]').forEach(item => {
            item.classList.toggle('dark');
        });

        // Salva o estado do tema no localStorage
        if (isDarkTheme) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
});


function showNotification(message) {
    const notification = document.getElementById("notification");
    notification.innerText = message;
    notification.style.display = "block"; // Exibe a notificação
    
    // Oculta a notificação após 2 segundos
    setTimeout(() => {
        notification.style.opacity = "0"; // Transição de opacidade para esconder
        setTimeout(() => {
            notification.style.display = "none";
            notification.style.opacity = "0.9"; // Reseta a opacidade para o próximo uso
        }, 500); // Espera o fim da transição para ocultar completamente
    }, 2000);
}

// Função para alternar entre os ícones de lâmpada ligada e desligada
function toggleLights() {
    const iconLightOn = document.querySelector('.icon-light-on');
    const iconLightOff = document.querySelector('.icon-light-off');

    // Se o ícone de lâmpada ligada estiver visível, ocultá-lo e mostrar o ícone de lâmpada desligada
    if (iconLightOn.style.display === 'block' || iconLightOn.style.display === '') {
        iconLightOn.style.display = 'none';
        iconLightOff.style.display = 'block';
        showNotification('Luzes Desligadas!');
    } else {
        // Caso contrário, mostrar o ícone de lâmpada ligada e ocultar o ícone de lâmpada desligada
        iconLightOn.style.display = 'block';
        iconLightOff.style.display = 'none';
        showNotification('Luzes Ligadas!');
    }
}

// Adiciona os eventos de clique para os ícones de ligar e desligar
document.getElementById('lightsOn').addEventListener('click', toggleLights);
document.getElementById('lightsOff').addEventListener('click', toggleLights);

// Ligar Luzes
document.querySelectorAll('[data-action="lightsOn"]').forEach(item => {
    item.addEventListener('click', function() {
        showNotification('Luzes Ligadas!');
        document.querySelector('.icon-light-on').style.display = 'none';
        document.querySelector('.icon-light-off').style.display = 'block';
    });
});

// Desligar Luzes
document.querySelectorAll('[data-action="lightsOff"]').forEach(item => {
    item.addEventListener('click', function() {
        showNotification('Luzes Desligadas!');
        document.querySelector('.icon-light-on').style.display = 'block';
        document.querySelector('.icon-light-off').style.display = 'none';
    });
});

document.querySelectorAll('#fanToggle, .dropdown-item[data-action="fanToggle"]').forEach(item => {
    item.addEventListener('click', function() {
        const fanButton = document.getElementById('fanToggle');
        const fanIcon = document.getElementById('fanIcon');

        // Alterna entre o estado ligado e desligado
        fanButton.classList.toggle('active');

        if (fanButton.classList.contains('active')) {
            showNotification('Ventoinha Ligada!');
            fanIcon.classList.replace('fa-fan', 'fa-fan'); // Atualize conforme necessário para mudar o ícone
        } else {
            showNotification('Ventoinha Desligada!');
            fanIcon.classList.replace('fa-fan', 'fa-fan'); // Atualize conforme necessário para mudar o ícone
        }
    });
});

// Bomba d'água
document.querySelectorAll('#waterPumpOn, #waterPumpOff').forEach(item => {
    item.addEventListener('click', function() {
        const pumpOn = document.getElementById('waterPumpOn');
        const pumpOff = document.getElementById('waterPumpOff');

        // Alterna entre o estado ligado e desligado
        pumpOn.style.display = pumpOn.style.display === 'none' ? 'block' : 'none';
        pumpOff.style.display = pumpOff.style.display === 'none' ? 'block' : 'none';

        if (pumpOn.style.display === 'none') {
            showNotification('Bomba de Água Ligada!');
        } else {
            showNotification('Bomba de Água Desligada!');
        }
    });
});




//parte simulada, excluir mais tarde.

  // Simulando a atualização da temperatura
 /* function updateTemperature(temp) {
    const fill = document.querySelector('.thermometer-fill');
    const temperatureValue = document.getElementById('temperature-value');
    
    // Ajusta a altura do preenchimento do termômetro (máximo de 100%)
    const height = Math.min(Math.max(temp, 0), 100);
    fill.style.height = height + '%';
    temperatureValue.textContent = temp + '°C';
}

// Exemplo de atualização com uma temperatura simulada
setTimeout(() => {
    updateTemperature(33); // Altere o valor conforme necessário para simular a temperatura
}, 1000);

    // Simulando a atualização da umidade
    function updateHumidity(humidity) {
        const waterLevel = document.querySelector('.water-level');
        const humidityValue = document.getElementById('humidity-value');
        
        // Ajusta a altura da água do aquário (máximo de 100%)
        const height = Math.min(Math.max(humidity, 0), 100);
        waterLevel.style.height = height + '%';
        humidityValue.textContent = humidity + '%';
    }

    // Exemplo de atualização com uma umidade simulada
    setTimeout(() => {
        updateHumidity(75); // Altere o valor conforme necessário para simular a umidade
    }, 1000);


        // Simulando a atualização da umidade do ar
        function updateAirHumidity(humidity) {
            const needle = document.querySelector('.gauge-needle');
            const humidityValue = document.getElementById('humidity-air-value');
            
            // Calcula o ângulo do ponteiro (0 a 180 graus para 0% a 100%)
            const angle = (humidity / 100) * 180 - 90;
            needle.style.transform = `rotate(${angle}deg)`;
            humidityValue.textContent = humidity + '%';
        }
    
        // Exemplo de atualização com uma umidade simulada
        setTimeout(() => {
            updateAirHumidity(75); // Altere o valor conforme necessário para simular a umidade
        }, 1000);*/


                // Função para obter o horário local do dispositivo e exibi-lo
        function displayLocalTime() {
            const now = new Date();
            const formattedTime = now.toLocaleString(); // Formata a data e hora de acordo com o fuso horário local
            document.getElementById('localTime').innerText = formattedTime; // Exibe o horário no elemento com id 'localTime'
        }

        // Chama a função ao carregar a página
        window.onload = function() {
            displayLocalTime();
        };

        // Atualiza o horário a cada segundo
        setInterval(displayLocalTime, 1000);



        document.addEventListener('DOMContentLoaded', function() {
            // Faz a requisição para obter os dados do clima
            fetch('/weather-from-ip')
                .then(response => response.json())
                .then(data => {
                    // Verifica se a resposta tem os dados esperados
                    if (data.error) {
                        console.error(data.error);
                        alert('Erro ao buscar informações de clima');
                        return;
                    }
    
                    // Atualiza o card com as informações de clima
                    document.getElementById('temperature').innerText = data.temperature ?? 'N/A';
                    document.getElementById('weatherDescription').innerText = data.weather_description ?? 'N/A';
                    document.getElementById('latitude').innerText = data.latitude ?? 'N/A';
                    document.getElementById('longitude').innerText = data.longitude ?? 'N/A';
                })
                .catch(error => {
                    console.error('Erro ao buscar os dados de clima:', error);
                });

                document.addEventListener('DOMContentLoaded', function() {
                    // Chama a função imediatamente ao carregar a página
                    fetchWeatherData();
            
                    // Atualiza as informações de clima a cada 10 minutos (600.000 ms)
                    setInterval(fetchWeatherData, 600000); // 600.000 ms = 10 minutos
                });
        });


        //caso o esp esteja desligado
        function showNotification(message) {
            const notification = document.getElementById("notification");
            notification.innerText = message;
            notification.style.display = "block"; // Exibe a notificação
        
            setTimeout(() => {
                notification.style.opacity = "0"; // Transição de opacidade para esconder
                setTimeout(() => {
                    notification.style.display = "none";
                    notification.style.opacity = "0.9"; // Reseta a opacidade para o próximo uso
                }, 500);
            }, 2000);
        }
        
        // Exemplo de uma requisição usando fetch com tratamento de erro
        function makeRequest(url) {
            fetch(url)
                .then(response => {
                    if (!response.ok) { // Verifica se a resposta não foi bem-sucedida
                        throw new Error('O dispositivo ESP está offline ou não respondeu.');
                    }
                    return response.json(); // Processa como JSON se espera essa resposta
                })
                .then(data => {
                    // Processa os dados aqui
                    showNotification('Operação bem-sucedida!');
                })
                .catch(error => {
                    console.error('Erro:', error); // Loga o erro para depuração
                });
        }
        
        // Exemplo de chamada da função
        makeRequest('/sua-url');



//mapa loc

document.addEventListener('DOMContentLoaded', function() {
    // URL para a API de localização por IP (substitua por seu serviço, se necessário)
    const ipInfoUrl = 'https://ipinfo.io/json?token=ed30f9f6c4d9e8'; // Substitua YOUR_TOKEN pelo seu token de API

    // Faz a requisição para obter a localização
    fetch(ipInfoUrl)
        .then(response => response.json())
        .then(data => {
            const [lat, lng] = data.loc.split(',').map(Number); // Divide a localização no formato "lat,lng" e converte para números
            const location = [lat, lng]; // Cria o array de localização para o Leaflet

            // Inicializa o mapa e centraliza na localização obtida
            const map = L.map('map').setView(location, 13);

            // Adiciona a camada de mapa do OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Adiciona um marcador na localização
            L.marker(location).addTo(map)
                .bindPopup('Localização Atual')
                .openPopup();
        })
        .catch(error => {
            console.error('Erro ao obter localização:', error);
            alert('Não foi possível obter a localização.');
        });
});
