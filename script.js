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
