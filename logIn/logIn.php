<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener los datos enviados en la solicitud POST
        $input = json_decode(file_get_contents('php://input'), true);

        $userName = isset($input['userName']) ? $input['userName'] : '';
        $password = isset($input['password']) ? $input['password'] : '';

        // Verificar si los campos están vacíos
        if (empty($userName) || empty($password)) {
            echo json_encode(array('success' => false, 'message' => 'Usuario y contraseña son requeridos'));
            exit;
        }

        // Incluir el archivo de configuración de la base de datos
        include '../baseDatos/configDB.php';

        // Conectar a la base de datos usando la función
        $conn = connectionDB();

        // Preparar la consulta SQL
        $sql = $conn->prepare("SELECT * FROM users WHERE userName = ? AND password = ?");
        $sql->bind_param("ss", $userName, $password);

        // Ejecutar la consulta
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $response = array('success' => true, 'message' => 'Inicio de sesión exitoso');
        } else {
            $response = array('success' => false, 'message' => 'Usuario o contraseña incorrectos');
        }

        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(array('success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()));
    } finally {
        // Cerrar la conexión si se ha establecido
        if (isset($sql)) {
            $sql->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
?>
