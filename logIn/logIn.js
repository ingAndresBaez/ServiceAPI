// logIn.js
async function logIn(event) {
    event.preventDefault(); // Previene el envío del formulario

    const userName = document.getElementById('nameUser').value;
    const password = document.getElementById('password').value;
alert(password);
    try {
        // Enviar los datos al archivo PHP usando fetch API
        const response = await fetch('logIn.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'userName': userName,
                'password': password
            })
        });

        // Inspeccionar el código de estado de la respuesta
        if (!response.ok) {
            throw new Error('Error en la solicitud12: ' + response.status + ' ' + response.statusText);
        }

        const data = await response.json();
        alert('Solicitud exitosa: ' + data.message);
    } catch (error) {
        console.error(error);
        alert('Error en la solicitud: ' + error.message);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    form.addEventListener('submit', logIn);
});
