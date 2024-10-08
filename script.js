// Função para atualizar o termômetro com base na temperatura
function updateThermometer(temperature) {
    // Define a altura do preenchimento em porcentagem
    const heightPercentage = (temperature / 100) * 100;

    // Atualiza a altura do termômetro preenchido
    const thermometerFill = document.getElementById('thermometer-fill');
    thermometerFill.style.height = `${heightPercentage}%`;

    // Atualiza o valor da temperatura exibido
    const temperatureValue = document.getElementById('temperature-value');
    temperatureValue.textContent = `${temperature.toFixed(1)}°C`;
}

// Simulando atualização de temperatura (substitua essa lógica para usar dados reais)
setInterval(() => {
    // Gera uma temperatura aleatória entre 0°C e 100°C
    const simulatedTemp = Math.floor(Math.random() * 101);
    updateThermometer(simulatedTemp);
}, 1000);
