<?php 

class usersController  extends controller{
    public function register(){
		if(isLoggedIn()){
            redirect('home\index');
          }else{
            if($_SERVER["REQUEST_METHOD"] == "POST"){
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
                if(empty($data["name"])){
                    $data["name_err"] = "Enter name";
                } elseif(strlen($data["name"])<2){
                    $data["name_err"] = "Name too short";
                }
                if(empty($data["surname"])){
                    $data["surname_err"] = "Enter surname";
                }elseif(strlen($data["surname"])<2){
                    $data["surname_err"] = "Surname too short";
                }
                /******************************************************************************************/
                $this->model('user',$data);
                $userModel=new user();
                $findUser = $userModel->findUser($data["email"]);
                /******************************************************************************************/
                if(empty($data["email"])){
                    $data["email_err"] = "Enter email";
                } elseif(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
                    $data["email_err"] = "Invalid Email";
                }elseif( $findUser){
                    $data["email_err"] = "User is already registered";
                } 
                if(empty($data["phone"])){
                    $data["phone_err"] = "Enter Phone number";
                } elseif(strlen($data["phone"]) < 10){
                    $data["phone_err"] = "Invalid number";
                } elseif(!is_numeric($data["phone"])){
                    $data["phone_err"] = "Invalid number";
                }
                if(empty($data["password"])){
                    $data["password_err"] = "Enter password";
                } elseif(strlen($data["password"]) < 6){
                    $data["password_err"] = "Password must be at least 6 characters";
                }elseif (!preg_match("#[0-9]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one number!";
                }elseif (!preg_match("#[a-zA-Z]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one letter!";
                }     
                if(empty($data["password2"])){
                    $data["password2_err"] = "Confirm password";
                }
                if($data["password"] !== $data["password2"]){
                    $data["password2_err"] = "Passwords do not match";
                }
                $IsValid = empty($data["name_err"]) && empty($data["surname_err"]) && empty($data["phone_err"]) && empty($data["city_err"]) && empty($data["password_err"]) && empty($data["password2_err"]);
                if($IsValid){
                    $password =$data["password"];

                    //Encrypting the password
                    $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

                    //Registering the user
                    $register=$userModel->registerUser($data);

                    //Starting user session
                    $userData = $userModel->getUser($data['email'],$password);
                    if($userData){
                        $this->createSession($userData);

                        $this->flash("Registration Successfull","Your registration @".SITENAME." was Successfull, thank you for registering enjoy",URLROOT.'home/index');
                                
                    }else{
                        $this->flash("Registration Unsuccessfull","Your registration @".SITENAME." was Unsuccessfull, please try again",URLROOT.'users/register');
                        }

                }else{
                    //echo 'err';
                    $this->view('home\register',$data);
                    $this->view->render();
                    //flash('success','success');
                }
            }else{
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

                $this->view('home\register',$data);
                    $this->view->render();
            }
        }
    }

    public function login(){
        if(isLoggedIn()){
            redirect('home\index');
          }else{
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //echo 'withinh';
                //data from the form is put in an array
                $data = [
                    
                    "email" => trim($_POST["email"]),
                                   
                    "password" => trim($_POST["password"]),
                    
                    "status" => "",
                    
                    "email_err" => "",
                                    
                    "password_err" => "",
                    
                ];

                $this->model('user',$data);
                $userModel=new user();
                $findUser = $userModel->findUser($data["email"]);

                /******************************************************************************************/
                if(empty($data["email"])){
                    $data["email_err"] = "Enter email";
                } elseif(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
                    $data["email_err"] = "Invalid Email";
                }elseif( !$findUser){
                    $data["email_err"] = "User is Not registered";
                }

                if(empty($data["email_err"]) && empty($data["password_err"])){
                    $userData = $userModel->getUser($data['email'],$data['password']);
                    if($userData){
                        $this->createSession($userData);
                        redirect('home\index');
                    }else{
                        $data['password_err']="Incorrect Password";
                        $this->view('home\login',$data);
                        $this->view->render();
                    }
                }else{
                        $this->view('home\login',$data);
                        $this->view->render();
                }


            }else{
                $data = [
                    "email" => "",     
                    "password" => "",
                    "status" => "",
                    "email_err" => "",
                    "password_err" => "",
                ];
                $this->view('home\login',$data);
                $this->view->render();
            }
        }
    }

    private function createSession($userData){
        if(isLoggedIn()){
            redirect('home\index');
        }else{
            $_SESSION['id']=$userData[0]['Id'];
            $_SESSION['email']=$userData[0]['Email'];
            $_SESSION['phone']=$userData[0]['Phone'];
            $_SESSION['name']=$userData[0]['FirstName']." ".$userData[0]['LastName'];  
        }
    }

    private function createAdminSession($userData){
        if(isLoggedIn()){
            redirect('home\index');
        }else{
            $_SESSION['id']=$userData[0]['Id'];
            $_SESSION['email']=$userData[0]['Email'];
            $_SESSION['status']=$userData[0]['Role'];
            $_SESSION['name']=$userData[0]['FirstName']." ".$userData[0]['LastName']."(".$userData[0]['Role'].")";
        } 
    }

    public function logout($confirm=false){
        if($confirm){
            if(!isLoggedIn()){
                $this->flash("Logging out","You are not logged in",URLROOT.'home/index');
              }else{
                unset($_SESSION['id']);
                unset($_SESSION['email']);
                session_destroy();
                $this->flash("Logging out","You have been Successfully logged out",URLROOT.'home/index');
                }
        }else{
            $this->warning("Logging out","Confirm you want to log out ","users\logout\\".true);
        }
        
    }


    

    public function changeSong($id){
        if(!isAdmin()){
            redirect('home\index');
        }else{
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                $data = [
                    "song" => trim($_POST["title"]),
                    "cover" => trim($_POST["Cover"]),
                    "artist" => trim($_POST["artist"]),
                    "action" => "",
                    "song_err"=>"",
                    "title_err"=>"",
                    "artist_err"=>"",
                    "cover_err"=>""  
                ];
                $data['id']=$id;
                $this->model('user',$data);
                $musicFile=new User;
                $ex = $musicFile->updateSong($data);
                if($ex){
                    $this->view('home\admin',$data);
                    $this->model('Music',$data);
                    $this->view->render();
                }else{
                    echo "something went wrong";
                }
             }else{
                $data = [
                    "song_err"=>"",
                    "title_err"=>"",
                    "artist_err"=>"",
                    "cover_err"=>""
                ];
                $this->model('user',$data);
                $musicFile=new User;
                $data =array_merge($musicFile->getSong($id)[0],$data);
                $this->view('home\changeSong',$data);
                $this->view->render();
            }
        }
    }

    public function deleteSong($id,$confirm=false){
        if ($confirm) {
            if(!isAdmin()){
                redirect('home\index');
            }else{

                $this->model('user',[]);
                $musicFile=new User;
                $data =$musicFile->getSong($id)[0];

                $isDeleted=$musicFile->DeleteSong($data['Id']);
                if($isDeleted||true){
                    $ex = $this->deletefile($data['Name']);
                    if($ex||true){

                                $this->flash("Deleted",$data['Name']." has been Successfully deleted",URLROOT.'home\admin');
                            }else{
                                $this->flash("Error",$data['Name']." deleted from file manager but not in database please delete from database manually",URLROOT.'home\admin');
                            }
                }else{
                     $this->flash("Error",$data['Name']." Either song has already deleted or title was changed before delete button was clicked please refresh browser ",URLROOT.'home\admin');
                }
            }
        }else{
            $this->model('user',[]);
            $musicFile=new User;
            $data =$musicFile->getSong($id)[0];
            $this->warning("Warning","Confirm Deletion of ".$data['Name'],"users\deleteSong\\".$id.'\\'.true);
            
        }
    }

    public function addSong(){
        if (!isAdmin()) {
            redirect('home\index');
        } else {
           
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //data from the form is put in an array
                $data = [
                    "song" => $_FILES["song"],
                    "title" => str_replace("'","",trim($_POST["title"])),
                    "artist" => str_replace("'","",trim($_POST["artist"])),
                    "cover" => $_FILES["cover"],

                    "song_err"=>"",
                    "title_err"=>"",
                    "artist_err"=>"",
                    "cover_err"=>""                    
                 ];

                 if(empty($data["song"])){
                    $data["song_err"] = "Choose a song";
                }

                if(empty($data["title"])){
                    $data["title_err"] = "Enter title";
                } elseif(strlen($data["title"])<2){
                    $data["title_err"] = "Title too short";
                }

                if(empty($data["artist"])){
                    $data["artist_err"] = "Enter artist";
                } elseif(strlen($data["artist"])<1){
                    $data["artist_err"] = "Artist too short";
                }

                if(empty($data["cover"])){
                    $data["cover_err"] = "Choose a cover";
                }


                 $data["song_err"]=$this->prepareFile($data['song'],'music',$data['title']);
                 if(!empty($data['cover']['name'])){
                    $data["cover_err"]=$this->prepareFile($data['cover'],'img/covers',$data['title']);
                    }
                 if(empty($data['song_err']) && empty($data['cover_err']) && empty($data['title_err']) && empty($data['artist_err'])){
                        $song=$data['song'];
                        $fileExt1 = explode('.',$song['name']);
                        $fileActualExt1 = strtolower(end($fileExt1));
                        $allow = array('jpg','jpeg','png','mp3');

                        
                        if(!in_array($fileActualExt, $allow)){
                            $fileActualExt1 = 'mp3';
                        }
                        $song1=$data['title'].'.'.$fileActualExt1;



                        
                        if(!empty($data['cover']['name'])){
                            $cover=$data['cover'];
                            $fileExt2 = explode('.',$cover['name']);
                            $fileActualExt2 = strtolower(end($fileExt2));               
                            $cover1=$data['title'].'.'.$fileActualExt2;
                            }else{
                                $cover1="cover1.jpg";
                            }


                        $this->model('user',$data);
                        $a = new user;
                        $a->UploadSong($song1,$data['artist'],$cover1);
                        $this->flash("Success","New song Successfully Added to playlist",URLROOT.'users\admin');

                 }else{
                    

                    $this->view('home\addSong',$data);
                        $this->view->render();
                 }          

                
            }else{
                $data = [
                    "song" => "",
                    
                    "title" => "",

                    "artist" => "",

                    "cover" => "",
                    "song_err"=>"",
                    "title_err"=>"",
                    "artist_err"=>"",
                    "cover_err"=>""

                ];

                $this->view('home\addSong',$data);
                        $this->view->render();
            }
        }
    }



	public function update(){
        if(!isAdmin()){
            redirect('home\index');
        }else{
    		if($_SERVER["REQUEST_METHOD"] == "POST"){
                //data from the form is put in an array
                $data = [
                    //"id" => trim($_POST["id"]),
                    "song" => trim($_POST["song"]),
                    "cover" => trim($_POST["cover"]),
                    "artist" => trim($_POST["artist"]),
                    "action" => "",

                    "song_err"=>"",
                    "title_err"=>"",
                    "artist_err"=>"",
                    "cover_err"=>""  
                    
                ];

                if(isset($_POST["delete"])){
                    $data['action']="DELETE";
                    $this->model('user',$data);
                    $musicFile=new User;
                    //$ex = $musicFile->DeleteSong($data['id']);
                    $isDeleted=$this->deletefile($data['song']);
                    if($isDeleted){
                        $ex = $musicFile->DeleteSong($data['id']);
                        if($ex){

                                    $this->flash("Deleted",$data['song']." has been Successfully deleted",URLROOT.'home\admin');
                                    // $this->view('home\admin',$data);
                                    // $this->model('Music',$data);
                                    // //$this->model->render1();
                                    // $this->view->render();
                                }else{
                                    $this->flash("Error",$data['song']." deleted from file manager but not in database please delete from database manually",URLROOT.'home\admin');
                                    // $data['song_err']="Song deleted from file manager but not in database please delete from database manually";
                                    // $this->model('Music',$data);
                                    // //$this->model->render1();
                                    // $this->view->render();
                                }
                    }else{
                         $this->flash("Error",$data['song']." Either song has already deleted or title was changed before delete button was clicked please refresh browser ",URLROOT.'home\admin');
                        // $data['song_err']="Either song already deleted or title was changed before delete button was clicked please refresh browser ";
                        // $this->view('home\admin',$data);
                        // $this->model('Music',$data);
                        // //$this->model->render1();
                        // $this->view->render();
                    }
                }else{

                    if(empty($data["song"])){
                            $data["song_err"] = "Enter song";
                        }elseif(strlen($data["song"])<1){
                            $data["song_err"] = "Song too short";
                        }

                        

                        if(empty($data["artist"])){
                            $data["artist_err"] = "Enter artist";
                        } elseif(strlen($data["artist"])<1){
                            $data["artist_err"] = "Artist too short";
                        }

                        if(empty($data["cover"])){
                            $data["cover_err"] = "Choose a cover";
                        }

                        if(empty($data['song_err']) && empty($data['artist_err']) && empty($data['cover_err'])){

                            $fileExt = explode('.',$data['song']);
                            $fileActualExt = strtolower(end($fileExt));

                            $allow = array('jpg','jpeg','png','mp3');


                            if(!in_array($fileActualExt, $allow)){
                                $data['song']=$data['song'].".mp3";
                            }

                            $fileExt2 = explode('.',$data['cover']);
                            $fileActualExt2 = strtolower(end($fileExt2));

                            $allow2 = array('jpg','jpeg','png','mp3');


                            if(!in_array($fileActualExt2, $allow2)){
                                $data['cover']=$data['cover'].".jpg";
                            }
            

                            $data['action']="UPDATE";
                            $this->model('user',$data);
                            $musicFile=new User;
                            $ex = $musicFile->updateSong($data);
                            if($ex){
                                $this->view('home\admin',$data);
                                $this->model('Music',$data);
                                //$this->model->render1();
                                $this->view->render();
                            }else{
                                echo "something went wrong";
                            }
                        }else{

                                $this->view('home\admin',$data);
                                $this->model('Music',$data);
                                //$this->model->render1();
                                $this->view->render();

                        }   



                    
                }
            }else{
                redirect('users/admin');
            }

            
        }
	}

	private function prepareFile($file,$folder,$title){
        if (!isAdmin()) {
            redirect('home/index');
        } else {
            $fileName = $file['name'];
            $fileTmpName =$file['tmp_name'];
            $fileSize = $file['size'];
            $fileError =$file['error'];
            $fileType = $file['type'];
            $fileExt = explode('.',$fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allow = array('jpg','jpeg','png','mp3');

            var_dump($fileActualExt);
            if(in_array($fileActualExt, $allow)){
                	
            	if ($fileError == 0) {
            		if ($fileSize<100000000) {
            			$fileNameNew = $title.'.'.$fileActualExt;
            			$fileDestination = ROOT.'/public/media/'.$folder.'/'.$fileNameNew;
            			move_uploaded_file($fileTmpName,$fileDestination);
            			return "";
            		}else{
            			return "your file is too big";
            		}
            	}else{
            		return "error uploading file";
            	}
            }else{
                $fileActualExt="mp3";
                if ($fileError == 0) {
                    if ($fileSize<100000000) {
                        $fileNameNew = $title.'.'.$fileActualExt;
                        $fileDestination = ROOT.'/public/media/'.$folder.'/'.$fileNameNew;
                        move_uploaded_file($fileTmpName,$fileDestination);
                        return "";
                    }else{
                        return "your file is too big";
                    }
                }else{
                    return "error uploading file";
                }
        	   
            }
        }    
	}
    public function admin(){
                if (isAdmin()) {
                    $this->model('music',[]);
                    $music=new Music();
                    $data=$music->getAllsong();
                    $this->view('home\admin',$data);
                    $this->view->render();
                 } else {          
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $data = [
                            "email" => trim($_POST["email"]),        
                            "password" => trim($_POST["password"]),
                            "status" => "",
                            "email_err" => "",     
                            "password_err" => "",
                        ];
                        $this->model('user',$data);
                        $userModel=new user();
                        $findUser = $userModel->findAdmin($data["email"]);

                        /******************************************************************************************/
                        if(empty($data["email"])){
                            $data["email_err"] = "Enter email";
                        } elseif(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
                            $data["email_err"] = "Invalid Email";
                        }elseif( !$findUser){
                            $data["email_err"] = "User is Not registered";
                        }

                        if(empty($data["email_err"]) && empty($data["password_err"])){
                            $userData = $userModel->getAdmin($data['email'],$data['password']);
                            if($userData){
                                $this->createAdminSession($userData);
                                redirect('home\admin');
                            }else{
                                $data['password_err']="Incorrect Password";
                                $this->view('home\loginAdmin',$data);
                                $this->view->render();
                            }
                        }else{
                                $this->view('home\loginAdmin',$data);
                                $this->view->render();
                        }

                    }else{
                        $data = [
                            
                            "email" => "",
                                           
                            "password" => "",
                            
                            "status" => "",
                            
                            "email_err" => "",
                                            
                            "password_err" => "",
                            
                        ];

                        $this->view('home\loginAdmin',$data);
                        $this->view->render();
                    }
                }
            
        
    }

    private function deletefile($file){
        $path = ROOT . "public\media\music/".$file;
        
        if(unlink($path)){
            return true;
        }else{
            return false;
        }
    }

    public function forgotpassword(){
        if(isLoggedIn()){
            redirect('home\index');
          }else{
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //echo 'withinh';
                //data from the form is put in an array
                $data = [
                    
                    "email" => trim($_POST["email"]),
                                   
                    "code"=>uniqid(),


                    
                    "message" => "",
                    
                    "email_err" => ""
                    
                ];

                $url=URLROOT."users/reset/".$data['code'];

                $this->model('user',$data);
                $userModel=new user();
                $findUser = $userModel->findUser($data["email"]);
                $findReset = $userModel->findReset($data["email"]);

                

                /******************************************************************************************/
                if(empty($data["email"])){
                    $data["email_err"] = "Enter email";
                } elseif(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
                    $data["email_err"] = "Invalid Email";
                }elseif( !$findUser){
                    $data["email_err"] = "User is Not registered";
                }elseif($findReset){
                    $data["email_err"] = "Link to reset password already sent";
                }

                if(empty($data["email_err"])){

                    $subject=SITENAME." Password reset link";
                    $body="GoTo: ".$url;
                    $mail=$this->sendEmail($data['email'],$subject,$body);
                    $dbsent=$userModel->inputReset($data);
                    if($mail || $dbsent){
                        $this->flash("Sent Successfull","Reset Link sent Successfully to ".$data['email']." please follow the link sent to you",URLROOT.'home\index');
                            
                       
                    }else{
                        $this->flash("Sent Unsuccessfull","Reset Link unsuccessfully sent to ".$data['email']." please try again",URLROOT.'users\forgotpassword');
                            
                    }

                }else{
                        $data['message']=$data['email_err'];
                        $this->view('home\forgotpassword',$data);
                        $this->view->render();
                    }

            }else{
                $data = [
                    
                    "email" => "",
                    
                    "message" => "",
                    
                    "email_err" => "",
                ];

                $this->view('home\forgotpassword',$data);
                $this->view->render();
            }
        }
    }

    public function sendEmail($reciever,$subject,$body){
        $mail = new PHPMailer(true);

        try {
            //Server settings

            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'freddymuleya16@gmail.com';                     // SMTP username
            $mail->Password   = '';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;   //ssl / 465                                 // TCP port to connect to

            //Recipients
            $mail->setFrom(SITENAME.'@gmail.com', SITENAME);
            $mail->addAddress($reciever);               // Name is optional
            $mail->addReplyTo('no-rely@'.SITENAME.'.com', 'Information');


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;

        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function reset($code=""){
        if(isLoggedIn()){
            redirect('home\index');
        }else{
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $data = [
                    
                    
                    "password" => trim($_POST["password"]),
                    "password2" => trim($_POST["password2"]),
                     "code"=>$code,      
                    "message" => "",
                    
                    "email" => "",
                    "password2_err"=>"",
                    "password_err"=>""
                    
                ];

                $this->model('user',$data);
                $userModel=new user();
                
                if(empty($data["password"])){
                    $data["password_err"] = "Enter password";
                } elseif(strlen($data["password"]) < 6){
                    $data["password_err"] = "Password must be at least 6 characters";
                }elseif (!preg_match("#[0-9]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one number!";
                }elseif (!preg_match("#[a-zA-Z]+#", $data["password"])) {
                    $data["password_err"] = "Password must include at least one letter!";
                }     

                if(empty($data["password2"])){
                    $data["password2_err"] = "Confirm password";
                }
                if($data["password"] !== $data["password2"]){
                    $data["password2_err"] = "Passwords do not match";
                }

                if(empty($data["password_err"]) && empty($data["password2_err"]) ){
                    if($userModel->findCode($code)){
                        $data['email']=$userModel->getEmail($code);
                        $data['password']=password_hash($data["password"], PASSWORD_BCRYPT);
                        if($userModel->resetPassword($data)){
                            if($userModel->removeCode($code)){
                                $this->flash("Password Reset","Your password was Successfully reset please make sure you remember it next time, thank you Enjoy",URLROOT.'home\index');
                            }else{
                                echo "Error code:h6ug89jth";
                            }
                        }else{
                            redirect("home\index");
                        }
                    }else{
                        echo "Error code:hgjtftf8872th";
                        $this->flash("Password Reset","Your password Reset link has already been used please request the link again, Thank you",URLROOT.'users\forgotpassword');
                    }            
                }else{
                    $this->view('home\reset',$data);
                    $this->view->render();              
                }
            }else{
                $data = [
                    
                    "password"=>"",
                    "password2"=>"",
                     "code"=>$code,
                    "message" => "",
                    
                    "email" => "",
                    "password2_err"=>"",
                    "password_err"=>""
                    
                ];

                $this->model('user',$data);
                $userModel=new user();
                if($userModel->findCode($code)){
                    $this->view('home\reset',$data);
                    $this->view->render();
                }else{
                    $this->flash("Invalid Code","The code provided is invalid please request the reset link again",URLROOT.'users\forgotpassword');
                            
                    
                }
            }
        }
           
    }


    public function contact(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $data = [
                'name'=>trim($_POST["name"]),
                'email'=>trim($_POST["email"]),
                'phone'=>trim($_POST["phone"]),
                'message'=>trim($_POST["message"]),

                'name_err'=>"",
                'email_err'=>"",
                'phone_err'=>"",
                'message_err'=>""
            ];

            if(isLoggedIn()){
                $data = [
                'name'=>trim($_SESSION["name"]),
                'email'=>trim($_SESSION["email"]),
                'phone'=>trim($_SESSION["phone"]),
                'message'=>trim($_POST["message"]),

                'name_err'=>"",
                'email_err'=>"",
                'phone_err'=>"",
                'message_err'=>""
            ];
            }


             //we validate the data
                if(empty($data["name"])){
                    $data["name_err"] = "Enter name";
                } elseif(strlen($data["name"])<2){
                    $data["name_err"] = "Name too short";
                }

                if(empty($data["email"])){
                    $data["email_err"] = "Enter email";
                } elseif(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
                    $data["email_err"] = "Invalid Email";
                }

                if(empty($data["phone"])){
                    $data["phone_err"] = "Enter Phone number";
                } elseif(strlen($data["phone"]) < 10){
                    $data["phone_err"] = "Invalid number";
                } elseif(!is_numeric($data["phone"])){
                    $data["phone_err"] = "Invalid number";
                }
                if(empty($data["message"])){
                    $data["message_err"] = "Enter message";
                } elseif(strlen($data["name"])<10){
                    $data["message_err"] = "Message too short";
                }

                if(empty($data['message_err']) && empty($data['phone_err']) && empty($data['email_err']) && empty($data['name_err'])){
                    $this->model('user',$data);
                    $inputMessage=new user;
                    $sendmessage=$this->sendEmail("freddymuleya16@gmail.com","Message From ".SITENAME,'Name: '.$data['name'].'<br>Phone number: '.$data['phone'].'<br>Email: '.$data['email'].'<br>Message: '.$data['message']);
                    if(/*$inputMessage->saveMessage($data)*/$sendmessage){
                        $this->flash("Message Sent",SITENAME." has recieved your message and an appropriate responce will be sent to ".$data['email'],URLROOT."home/index");
                    }else{
                        $this->flash("Message Not Sent","Error occured please try again",URLROOT."users/contact");
                    }
                }else{
                    $this->view('home\contact',$data);
                    $this->view->render();
                }

        }else{
            $data = [
                'name'=>"",
                'email'=>"",
                'phone'=>"",
                'message'=>"",

                'name_err'=>"",
                'email_err'=>"",
                'phone_err'=>"",
                'message_err'=>""
            ];
            $this->view('home\contact',$data);
            $this->view->render();
        }
    }

    public function loginWithGoogle(){
        //haha finish this
    }
}