// document.addEventListener('DOMContentLoaded', () => {
//     const menuToggle = document.getElementById('menu-toggle');
//     const sidebar = document.getElementById('sidebar');
//     if (menuToggle && sidebar) {
//         menuToggle.addEventListener('click', () => {
//             // sidebar.classList.toggle('open');
//             const isOpen = sidebar.classList.toggle('open');

//             menuToggle.innerHTML = isOpen ? '✕' : '☰';
//         });
//     }
// }
// );
document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', () => {
            // Toggleamos la clase 'open' en el botón (para la animación de la X)
            menuToggle.classList.toggle('open');
            
            // Toggleamos la clase 'open' en el sidebar (para que aparezca)
            sidebar.classList.toggle('open');
        });
    }
});