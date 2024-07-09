<?php
class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUser() {
        $sql = "SELECT * FROM users";
        $result = $this->db->query($sql);

        if ($result) {
            $data = array();
            while ($fila = $result->fetch_assoc()) {
                $data[] = $fila;
            }
            echo json_encode($data);
        }
    }

    public function postUser() {
        try {
            // Decodificar el JSON de entrada
            $data = json_decode(file_get_contents('php://input'), true);
        
            // Verificar que los datos necesarios están presentes
            if (!isset($data['userName']) || !isset($data['password'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                return;
            }
        
            // Escapar datos para evitar inyección SQL
            $userName = $this->db->real_escape_string($data['userName']);
            $password = password_hash($data['password'], PASSWORD_BCRYPT);
        
            // Usar una declaración preparada para evitar la inyección SQL
            $stmt = $this->db->prepare("INSERT INTO users (userName, password) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $userName, $password);
                $result = $stmt->execute();
        
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Signup successful']);
                } else {
                    // Registrar el error de la base de datos
                    error_log("Database error: " . $stmt->error);
                    echo json_encode(['success' => false, 'message' => 'Signup failed']);
                }
        
                $stmt->close();
            } else {
                // Registrar el error de la base de datos
                error_log("Database prepare error: " . $this->db->error);
                echo json_encode(['success' => false, 'message' => 'Signup failed']);
            }
        } catch (Exception $e) {
            // Capturar cualquier excepción y registrar el mensaje de error
            error_log("Exception: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Signup failed']);
        }
    }
    
    

    public function loginUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $userName = $this->db->real_escape_string($data['userName']);
        $password = $data['password'];

        $sql = "SELECT * FROM users WHERE userName = '$userName'";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                echo json_encode(['success' => true, 'message' => 'Login successful']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid password']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    }
}

