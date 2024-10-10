// Alternar Tema
document.querySelectorAll('#themeToggle, .dropdown-item[data-action="themeToggle"]').forEach(item => {
    item.addEventListener('click', function() {
        document.body.classList.toggle('dark-theme');
        document.querySelector('#themeToggle').classList.toggle('dark');
    });
});


// Função para alternar entre os ícones de lâmpada ligada e desligada
function toggleLights() {
    const iconLightOn = document.querySelector('.icon-light-on');
    const iconLightOff = document.querySelector('.icon-light-off');

    // Se o ícone de lâmpada ligada estiver visível, ocultá-lo e mostrar o ícone de lâmpada desligada
    if (iconLightOn.style.display === 'block' || iconLightOn.style.display === '') {
        iconLightOn.style.display = 'none';
        iconLightOff.style.display = 'block';
        alert('Luzes Desligadas!');
    } else {
        // Caso contrário, mostrar o ícone de lâmpada ligada e ocultar o ícone de lâmpada desligada
        iconLightOn.style.display = 'block';
        iconLightOff.style.display = 'none';
        alert('Luzes Ligadas!');
    }
}

// Adiciona os eventos de clique para os ícones de ligar e desligar
document.getElementById('lightsOn').addEventListener('click', toggleLights);
document.getElementById('lightsOff').addEventListener('click', toggleLights);

// Ligar Luzes
document.querySelectorAll('[data-action="lightsOn"]').forEach(item => {
    item.addEventListener('click', function() {
        alert('Luzes Ligadas!');
        document.querySelector('.icon-light-on').style.display = 'none';
        document.querySelector('.icon-light-off').style.display = 'block';
    });
});

// Desligar Luzes
document.querySelectorAll('[data-action="lightsOff"]').forEach(item => {
    item.addEventListener('click', function() {
        alert('Luzes Desligadas!');
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
            alert('Ventoinha Ligada!');
            fanIcon.classList.replace('fa-fan', 'fa-fan'); // Atualize conforme necessário para mudar o ícone
        } else {
            alert('Ventoinha Desligada!');
            fanIcon.classList.replace('fa-fan', 'fa-fan'); // Atualize conforme necessário para mudar o ícone
        }
    });
});



//parte simulada, excluir mais tarde.

  // Simulando a atualização da temperatura
  function updateTemperature(temp) {
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
        }, 1000);