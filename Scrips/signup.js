document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('signupForm');
    const passwordInput = document.getElementById('password1');
    const vePasswordInput = document.getElementById('ve_password');
    const passwordError = document.getElementById('passwordError');

    // Verifica si los elementos del DOM están presentes
    if (!form || !passwordInput || !vePasswordInput || !passwordError) {
        console.error('No se encontraron algunos elementos del DOM.');
        return;
    }

    // Función para verificar si las contraseñas coinciden
    const validatePasswords = () => {
        if (passwordInput.value !== vePasswordInput.value) {
            passwordError.textContent = 'Las contraseñas no coinciden';
            return false;
        } else {
            passwordError.textContent = '';
            return true;
        }
    };

    // Validar contraseñas en tiempo real
    passwordInput.addEventListener('input', validatePasswords);
    vePasswordInput.addEventListener('input', validatePasswords);

    // Enviar el formulario usando fetch
    form.addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita el envío del formulario tradicional

        if (!validatePasswords()) {
            return; // Si las contraseñas no coinciden, no enviar el formulario
        }

        
        const userName = document.getElementById('userName1').value; // Usar .value para obtener el valor del input
        const password = document.getElementById('password1').value; // Usar .value para obtener el valor del input


        try {
            const response = await fetch('../restAPI/petition.php/signup', {
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
    });
});
