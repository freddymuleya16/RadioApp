<?php

class Controller
{
	protected $view;
	protected $model;
	public function view($viewName, $data = [])
	{
		$this->view = new View($viewName, $data);
		return $this->view;
	}
	public function model($model, $data = [])
	{

		$this->model = new Model($model, $data);
		return $this->model;
	}
	public function flash($name = '', $message = '', $class = '#')
	{
		$data = [
			'name' => $name,
			'message' => $message,
			'class' => $class
		];
		$this->view("inc\popUp", $data);
		
	}
	public function warning($name = '', $message = '', $class = '#')
	{
		$data = [
			'name' => $name,
			'message' => $message,
			'class' => URLROOT . $class
		];
		$this->view("inc\warning", $data);
		
	}
	public function sendEmail($reciever, $subject, $body)
    {
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
            $mail->setFrom(SITENAME . '@gmail.com', SITENAME);
            $mail->addAddress($reciever);               // Name is optional
            $mail->addReplyTo('no-rely@' . SITENAME . '.com', 'Information');


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
}
