<?php 


class LoginController {

    private $userModel;
    private $db;

    public function __construct() {

        
        // Set the include path
        set_include_path(get_include_path() . PATH_SEPARATOR . '../models');
        // Load the model file
        require_once 'UserModel.php';
        
    }

    public function setParams($params)
    {
        if (isset($params['db'])) {
            $this->db = $params['db'];
        }
    }


    public function handleLogin($db, $username, $password) {
        
        $userModel = new UserModel($db);   
        $errors = array();
        if (empty($username)) {
            array_push($errors, "Username is required.");
        }
        if (empty($password)) {
            array_push($errors, "Password is required.");
        }



        if (empty($errors)) {
            // All data is valid, proceed with login
            // Call the user login function in UserModel
            $loginResult = $userModel->loginUser($db, $username, $password);
            if ($loginResult === true) {
                // Login successful, redirect to the home page
                header('Location: /dashboard');
                exit;
            } else {
                array_push($errors, "Wrong username or password.");
                return $errors;
            }
        } else {
            return $errors;
        }
    }




    public function index() {
        $titlePage = 'Strenghtify - Login';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve POST data
            $loginInput = $_POST['login_input'];
            $password = $_POST['password'];

            // Call the registration function
            $loginResult = $this->handleLogin($this->db, $loginInput, $password);
            

            
            if ($loginResult !== true) {
                // Registration failed, $registration_result contains validation errors
                
                $errors = $loginResult;

            }
        }

        // Load the login view with any necessary data
        require_once '../views/shared/head.php';
        require_once '../views/login/login_form.php';
        require_once '../views/shared/footer.php';
    }



}




/*
    // Log the user out
    public function logout() {
        // Implement this function to log the user out and redirect
    }

    // Redirect to the home page if authenticated
    public function redirectToHomeIfAuthenticated() {
        // Implement this function to check if the user is authenticated and redirect
    }

    // Handle a failed login attempt
    protected function handleFailedLogin() {
        // Implement this function to handle a failed login attempt
    }

    // Reset a user's password
    public function resetPassword(Request $request) {
        // Implement this function to handle password reset
    }

    // Change a user's password
    public function changePassword(Request $request) {
        // Implement this function to handle password change
    }

    // Handle two-factor authentication
    public function twoFactorAuth(Request $request) {
        // Implement this function to handle two-factor authentication
    }

    // Handle social login callback
    public function socialLoginCallback(Request $request) {
        // Implement this function to handle social login callbacks
    }

    // Remember the user's session
    protected function rememberMe(Request $request) {
        // Implement this function to handle "Remember Me" functionality
    }

    // Add error handling functions
    protected function handleAuthenticationError() {
        // Implement this function to handle authentication errors
    }
*/