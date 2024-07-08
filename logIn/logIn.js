// logIn.js
async function logIn(event) {
    event.preventDefault(); // Previene el envío del formulario

    const userName = document.getElementById('nameUser').value;
    const password = document.getElementById('password').value;
alert(password);
    try {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'logIn.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
    
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    alert('Solicitud exitosa: ' + response.message);
                } else {
                    alert('Error en la solicitud: ' + xhr.status);
                }
            }
        };
    
        const data = JSON.stringify({
            userName: userName,
            password: password
        });
    
        xhr.send(data);
    } catch (error) {
        console.error(error);
        alert('Error en la solicitud: ' + error.message);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    form.addEventListener('submit', logIn);
});
