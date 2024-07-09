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
        $data = json_decode(file_get_contents('php://input'), true);
        $userName = $this->db->real_escape_string($data['userName']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (userName, password) VALUES ('$userName', '$password')";
        $result = $this->db->query($sql);

        if ($result) {
            $response['user_id'] = $this->db->insert_id;
            echo json_encode($response);
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

