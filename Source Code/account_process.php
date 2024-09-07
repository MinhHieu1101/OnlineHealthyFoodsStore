<?php
class UserAccount {
    private $dbConnection;

    public function __construct($dsn, $username, $password) {
        try {
            $this->dbConnection = new PDO($dsn, $username, $password);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function register($name1, $email, $phoneNumber, $password1) {
        //Validate the inputs
        if ($this->validateEmail($email) && $this->validatePhoneNumber($phoneNumber) && !empty($name1) && !empty($password1)) {		
			$name = $this->sanitize($name1);
			$password = $this->sanitize($password1);
			$hashedPassword = md5($password);

            //Insert user into the database
            $sql = "INSERT INTO Users (user_id, name, email, password, phoneno) VALUES (NULL, :name, :email, :password, :phone_number)";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
				':password' => $hashedPassword,
                ':phone_number' => $phoneNumber
            ]);

			$userId = $this->dbConnection->lastInsertId();
			$this->UserInfo($userId, $name, $email, $phoneNumber);
            //Redirect to user page
            $_SESSION['message'] = 'Registration complete! Please wait...';
			//header("Refresh:10; url=user.php");
            //exit();
        } else {
			$_SESSION['message'] = 'There is a problem with the registration! Please check your information carefully!';
			return false;
		}
    }

    public function login($email, $password1) {
        if ($this->validateEmail($email) && !empty($password1)) {
			$password = $this->sanitize($password1);
            //Check user in the database
            $sql = "SELECT * FROM Users WHERE email = :email";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            //Verify password
			$checkPassword = md5($password);
			if ($checkPassword === $user['password']) {
				$this->UserInfo($user['user_id'], $user['name'], $user['email'], $user['phoneno']);
                //Redirect to user page
                $_SESSION['message'] = 'Login successful! Please wait...';
				//header("Refresh:10; url=user.php");
                //exit();
            } else {
				$_SESSION['message'] = 'Please verify your account!';
				return false;
			}
        } else {

			//If failed login
			$_SESSION['message'] = 'Please verify your account!';
			return false;
		}
	}

    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validatePhoneNumber($phoneNumber) {
        return preg_match('/^[0-9]{10,}$/', $phoneNumber);
    }

	private function sanitize($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	private function UserInfo($userId, $name, $email, $phoneNumber) {
        $_SESSION['user_info'] = [
            'name' => $name,
            'email' => $email,
            'phoneNumber' => $phoneNumber
        ];
        $_SESSION['user_id'] = $userId;
    }
}
?>