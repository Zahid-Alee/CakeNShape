<?php
namespace DataSource;

class user
{

    private $conn;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->conn = new DataSource();
    }

    /**
     * to check if the username already exists
     *
     * @param string $username
     * @return boolean
     */
    public function isUsernameExists($username)
    {
        $query = 'SELECT * FROM users where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $resultArray = $this->conn->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to check if the email already exists
     *
     * @param string $email
     * @return boolean
     */
    public function isEmailExists($email)
    {
        $query = 'SELECT * FROM users where email = ?';
        $paramType = 's';
        $paramValue = array(
            $email
        );
        $resultArray = $this->conn->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to signup / register a user
     *
     * @return string[] registration status message
     */
    public function registeruser()
    {
        $isUsernameExists = $this->isUsernameExists($_POST["username"]);
        $isEmailExists = $this->isEmailExists($_POST["email"]);
        if ($isUsernameExists) {
            $response = array(
                "status" => "error",
                "message" => "Username already exists."
            );
        } else if ($isEmailExists) {
            $response = array(
                "status" => "error",
                "message" => "Email already exists."
            );
        } else {
            if (! empty($_POST["signup-password"])) {

                // PHP's password_hash is the best choice to use to store passwords
                // do not attempt to do your own encryption, it is not safe
                $hashedPassword = password_hash($_POST["signup-password"], PASSWORD_DEFAULT);
            }
            $query = 'INSERT INTO users (username, password, email) VALUES (?, ?, ?)';
            $paramType = 'sss';
            $paramValue = array(
                $_POST["username"],
                $hashedPassword,
                $_POST["email"]
            );
            $userId = $this->conn->insert($query, $paramType, $paramValue);
            if (! empty($userId)) {
                $response = array(
                    "status" => "success",
                    "message" => "You have registered successfully."
                );
            }
        }
        return $response;
    }

    public function getuser($username)
    {
        $query = 'SELECT * FROM users where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $userRecord = $this->conn->select($query, $paramType, $paramValue);
        return $userRecord;
    }

    /**
     * to login a user
     *
     * @return string
     */
    public function loginuser()
    {
        $userRecord = $this->getuser($_POST["username"]);
        $loginPassword = 0;
        if (! empty($userRecord)) {
            if (! empty($_POST["login-password"])) {
                $password = $_POST["login-password"];
            }
            $hashedPassword = $userRecord[0]["password"];
            $loginPassword = false;
            if (password_verify($password, $hashedPassword)) {
                $loginPassword = true;
            }
        } else {
            $loginPassword = false;
        }
        if ($loginPassword == true) {
            // login sucess so store the user's username in
            // the session
            session_start();
            $_SESSION["username"] = $userRecord[0]["username"];
            $_SESSION["role"] = $userRecord[0]["role"];
            $_SESSION['userID']=$userRecord[0]["userID"];
            session_write_close();
            $url = "./index.php";
            header("Location: $url");
        } else if ($loginPassword == 0) {
            $loginStatus = "Invalid username or password.";
            return $loginStatus;
        }
    }
   
}
