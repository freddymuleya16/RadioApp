<?php

class AccountController  extends controller
{
    public function register()
    {
        if (isLoggedIn()) {
            redirect('home\index');
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $data = [

                    "name" => trim($_POST["name"]),
                    "surname" => trim($_POST["l_name"]),
                    "email" => trim($_POST["email"]),
                    "phone" => trim($_POST["phone"]),
                    "password" => trim($_POST["password"]),
                    "password2" => trim($_POST["c_password"]),
                    "IsActive" => "1",
                    "name_err" => "",
                    "surname_err" => "",
                    "email_err" => "",
                    "phone_err" => "",
                    "password_err" => "",
                    "password2_err" => "",
                ];

                //we validate the data
                if (empty($data["name"])) {
                    $data["name_err"] = "Enter name";
                } elseif (strlen($data["name"]) < 2) {
                    $data["name_err"] = "Name too short";
                }
                if (empty($data["surname"])) {
                    $data["surname_err"] = "Enter surname";
                } elseif (strlen($data["surname"]) < 2) {
                    $data["surname_err"] = "Surname too short";
                }
                /******************************************************************************************/
                $this->model('user', $data);
                $userModel = new user();
                $findUser = $userModel->findUser($data["email"]);
                /******************************************************************************************/
                if (empty($data["email"])) {
                    $data["email_err"] = "Enter email";
                } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                    $data["email_err"] = "Invalid Email";
                } elseif ($findUser) {
                    $data["email_err"] = "User is already registered";
                }
                if (empty($data["phone"])) {
                    $data["phone_err"] = "Enter Phone number";
                } elseif (strlen($data["phone"]) < 10) {
                    $data["phone_err"] = "Invalid number";
                } elseif (!is_numeric($data["phone"])) {
                    $data["phone_err"] = "Invalid number";
                }
                if (empty($data["password"])) {
                    $data["password_err"] = "Enter password";
                } elseif (strlen($data["password"]) < 6) {
                    $data["password_err"] = "Password must be at least 6 characters";
                } elseif (!preg_match("#[0-9]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one number!";
                } elseif (!preg_match("#[a-zA-Z]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one letter!";
                }
                if (empty($data["password2"])) {
                    $data["password2_err"] = "Confirm password";
                }
                if ($data["password"] !== $data["password2"]) {
                    $data["password2_err"] = "Passwords do not match";
                }
                $IsValid = empty($data["name_err"]) && empty($data["surname_err"]) && empty($data["phone_err"]) && empty($data["city_err"]) && empty($data["password_err"]) && empty($data["password2_err"]);
                if ($IsValid) {
                    $password = $data["password"];

                    //Encrypting the password
                    $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

                    //Registering the user
                    $register = $userModel->registerUser($data);

                    //Starting user session
                    $userData = $userModel->getUser($data['email'], $password);
                    if ($userData) {
                        $this->createSession($userData);

                        $this->flash("Registration Successfull", "Your registration @" . SITENAME . " was Successfull, thank you for registering enjoy", URLROOT . 'Account/index');
                    } else {
                        $this->flash("Registration Unsuccessfull", "Your registration @" . SITENAME . " was Unsuccessfull, please try again", URLROOT . 'Account/register');
                    }
                } else {
                    //echo 'err';
                    $this->view('Account\register', $data);
                    
                    //flash('success','success');
                }
            } else {
                $data = [

                    "name" => "",
                    "surname" => "",
                    "email" => "",
                    "phone" => "",
                    "password" => "",
                    "password2" => "",
                    "status" => "0",
                    "name_err" => "",
                    "surname_err" => "",
                    "email_err" => "",
                    "phone_err" => "",
                    "password_err" => "",
                    "password2_err" => "",
                ];

                $this->view('Account\register', $data);
                
            }
        }
    }

    public function login()
    {
        if (isLoggedIn()) {
            redirect('home\index');
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //echo 'withinh';
                //data from the form is put in an array
                $data = [

                    "email" => trim($_POST["email"]),

                    "password" => trim($_POST["password"]),

                    "status" => "",

                    "email_err" => "",

                    "password_err" => "",

                ];

                $this->model('user', $data);
                $userModel = new user();
                $findUser = $userModel->findUser($data["email"]);

                /******************************************************************************************/
                if (empty($data["email"])) {
                    $data["email_err"] = "Enter email";
                } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                    $data["email_err"] = "Invalid Email";
                } elseif (!$findUser) {
                    $data["email_err"] = "User is Not registered";
                }

                if (empty($data["email_err"]) && empty($data["password_err"])) {
                    $userData = $userModel->getUser($data['email'], $data['password']);
                    if ($userData) {
                        $this->createSession($userData);
                        redirect('home\index');
                    } else {
                        $data['password_err'] = "Incorrect Password";
                        $this->view('Account\login', $data);
                        
                    }
                } else {
                    $this->view('Account\login', $data);
                    
                }
            } else {
                $data = [
                    "email" => "",
                    "password" => "",
                    "status" => "",
                    "email_err" => "",
                    "password_err" => "",
                ];
                $this->view('Account\login', $data);
                
            }
        }
    }

    private function createSession($userData)
    {
        if (isLoggedIn()) {
            redirect('home\index');
        } else {
            $_SESSION['id'] = $userData[0]['Id'];
            $_SESSION['email'] = $userData[0]['Email'];
            $_SESSION['phone'] = $userData[0]['Phone'];
            $_SESSION['name'] = $userData[0]['FirstName'] . " " . $userData[0]['LastName'];
        }
    }

    private function createAdminSession($userData)
    {
        if (isLoggedIn()) {
            redirect('home\index');
        } else {
            $_SESSION['id'] = $userData[0]['Id'];
            $_SESSION['email'] = $userData[0]['Email'];
            $_SESSION['status'] = $userData[0]['Role'];
            $_SESSION['name'] = $userData[0]['FirstName'] . " " . $userData[0]['LastName'] . "(" . $userData[0]['Role'] . ")";
        }
    }

    public function logout($confirm = false)
    {
        if ($confirm) {
            if (!isLoggedIn()) {
                $this->flash("Logging out", "You are not logged in", URLROOT . 'home/index');
            } else {
                unset($_SESSION['id']);
                unset($_SESSION['email']);
                session_destroy();
                $this->flash("Logging out", "You have been Successfully logged out", URLROOT . 'home/index');
            }
        } else {
            $this->warning("Logging out", "Confirm you want to log out ", "Account\logout\\" . true);
        }
    }
    
    public function forgotpassword()
    {
        if (isLoggedIn()) {
            redirect('home\index');
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
               
                $data = [

                    "email" => trim($_POST["email"]),

                    "code" => uniqid(),

                    "message" => "",

                    "email_err" => ""

                ];

                $url = URLROOT . "Account/reset/" . $data['code'];

                //$this->model('user', $data);
                $userModel = new User();
                $findUser = $userModel->findUser($data["email"]);

                $resetPassowrdModel =new ResetPassword();

                $findReset =$resetPassowrdModel->findReset($data["email"]);



                /******************************************************************************************/
                if (empty($data["email"])) {
                    $data["email_err"] = "Enter email";
                } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                    $data["email_err"] = "Invalid Email";
                } elseif (!$findUser) {
                    $data["email_err"] = "User is Not registered";
                } elseif ($findReset) {
                    $data["email_err"] = "Link to reset password already sent";
                }

                if (empty($data["email_err"])) {

                    $subject = SITENAME . "Password reset link";
                    $body = "GoTo: " . $url;
                    $mail = $this->sendEmail($data['email'], $subject, $body);
                    $dbsent = $resetPassowrdModel->inputReset($data);
                    if ($mail || $dbsent) {
                        $this->flash("Sent Successfull", "Reset Link sent Successfully to " . $data['email'] . " please follow the link sent to you", URLROOT . 'Account\index');
                    } else {
                        $this->flash("Sent Unsuccessfull", "Reset Link unsuccessfully sent to " . $data['email'] . " please try again", URLROOT . 'Account\forgotpassword');
                    }
                } else {
                    $data['message'] = $data['email_err'];
                    $this->view('Account\forgotpassword', $data);
                    
                }
            } else {
                $data = [

                    "email" => "",

                    "message" => "",

                    "email_err" => "",
                ];

                $this->view('Account\forgotpassword', $data);
                
            }
        }
    }

    

    public function reset($code = "")
    {
        if (isLoggedIn()) {
            redirect('home\index');
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $data = [


                    "password" => trim($_POST["password"]),
                    "password2" => trim($_POST["password2"]),
                    "code" => $code,
                    "message" => "",
                    "email" => "",
                    "password2_err" => "",
                    "password_err" => ""

                ];
                $userModel = new User();
                $resetPassowrdModel =new ResetPassword();


                if (empty($data["password"])) {
                    $data["password_err"] = "Enter password";
                } elseif (strlen($data["password"]) < 6) {
                    $data["password_err"] = "Password must be at least 6 characters";
                } elseif (!preg_match("#[0-9]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one number!";
                } elseif (!preg_match("#[a-zA-Z]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one letter!";
                }

                if (empty($data["password2"])) {
                    $data["password2_err"] = "Confirm password";
                }
                if ($data["password"] !== $data["password2"]) {
                    $data["password2_err"] = "Passwords do not match";
                }

                if (empty($data["password_err"]) && empty($data["password2_err"])) {
                    if ($resetPassowrdModel->findCode($code)) {
                        $data['email'] = $resetPassowrdModel->getEmail($code);
                        $data['password'] = password_hash($data["password"], PASSWORD_BCRYPT);
                        if ($userModel->resetPassword($data)) {
                            if ($resetPassowrdModel->removeCode($code)) {
                                $this->flash("Password Reset", "Your password was Successfully reset please make sure you remember it next time, thank you Enjoy", URLROOT . 'home\index');
                            } else {
                                echo "Error code:h6ug89jth";
                            }
                        } else {
                            redirect("home\index");
                        }
                    } else {
                        echo "Error code:hgjtftf8872th";
                        $this->flash("Password Reset", "Your password Reset link has already been used please request the link again, Thank you", URLROOT . 'Account\forgotpassword');
                    }
                } else {
                    $this->view('Account\reset', $data);
                    
                }
            } else {
                $data = [

                    "password" => "",
                    "password2" => "",
                    "code" => $code,
                    "message" => "",

                    "email" => "",
                    "password2_err" => "",
                    "password_err" => ""

                ];

                $resetPassowrdModel = new ResetPassword();
                if ($resetPassowrdModel->findCode($code)) {
                    $this->view('Account\reset', $data);
                } else {
                    $this->flash("Invalid Code", "The code provided is invalid please request the reset link again", URLROOT . 'Account\forgotpassword');
                }
            }
        }
    }
    public function loginWithGoogle()
    {
        //haha finish this
    }

    public function admin(){
        if(isLoggedIn()){
            $this->logout(true);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $data = [
                    "email" => trim($_POST["email"]),
                    "password" => trim($_POST["password"]),
                    "status" => "",
                    "email_err" => "",
                    "password_err" => "",
                ];
                //$this->model('user', $data);
                $userModel = new Admin();
                $findUser = $userModel->findAdmin($data["email"]);

                /******************************************************************************************/
                if (empty($data["email"])) {
                    $data["email_err"] = "Enter email";
                } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                    $data["email_err"] = "Invalid Email";
                } elseif (!$findUser) {
                    $data["email_err"] = "User is Not registered";
                }

                if (empty($data["email_err"]) && empty($data["password_err"])) {
                    $userData = $userModel->getAdmin($data['email'], $data['password']);
                    if ($userData) {
                        $this->createAdminSession($userData);
                        redirect('Song\index');
                    } else {
                        $data['password_err'] = "Incorrect Password";
                        $this->view('Account\loginAdmin', $data);
                       // 
                    }
                } else {
                    $this->view('Account\loginAdmin', $data);
                   // 
                }
            } else {
                $data = [

                    "email" => "",

                    "password" => "",

                    "status" => "",

                    "email_err" => "",

                    "password_err" => "",

                ];

                $this->view('Account\loginAdmin', $data);
                //
    }
}
}
