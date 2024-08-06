async function logIn(event) {
    event.preventDefault(); // Previene el envío del formulario

    const userName = document.getElementById('nameUser').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('../restAPI/petition.php/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                userName: userName,
                password: password
            })
        });

        if (response.ok) {
            const data = await response.json();
            alert('Solicitud exitos: ' + data.message);
        } else {
            alert('Error en la solicitud1: ' + response.status);
        }
    } catch (error) {
        console.error(error);
        alert('Error en la solicitud2: ' + error.message);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    form.addEventListener('submit', logIn);
});
