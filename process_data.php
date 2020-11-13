<?php

//process_data.php

if(isset($_POST["name"]))
{
 $name = '';
 $email = '';
 $phone = '';
 $dob = '';

 $name_error = '';
 $email_error = '';
 $phone_error = '';
 $dob_error = '';
 $captcha_error = '';

 if(empty($_POST["name"]))
 {
  $name_error = 'name is required';
 }
 else
 {
  $name = $_POST["name"];
 }

 if(empty($_POST["email"]))
 {
  $email_error = 'Email is required';
 }
 else
 {
  if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
  {
   $email_error = 'Invalid Email';
  }
  else
  {
   $email = $_POST["email"];
  }
 }
 if(empty($_POST["phone"]))
 {
  $phone_error = 'Phone is required';
 }
 else
 {
  $phone = $_POST["phone"];
 }
 if(empty($_POST["dob"]))
 {
  $dob = $_POST["dob"];
 }


 if(empty($_POST['g-recaptcha-response']))
 {
  $captcha_error = 'Captcha is required';
 }
 else
 {
  $secret_key = '6LfVZOIZAAAAAC1l9vRvyTWr0pbB5zP438vYs2wO';

  $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

  $response_data = json_decode($response);

  if(!$response_data->success)
  {
   $captcha_error = 'Captcha verified';
  }
 }

 if($name_error == '' && $email_error == '' && $phone_error == '' && $dob_error == '' && $captcha_error == '')
 {
  $data = array(
   'success'  => true
  );
 }
 else
 {
  $data = array(
   'name_error' => $name_error,
   'email_error' => $email_error,
   'phone_error'  => $phone_error,
   'dob_error' => $dob_error,
   'captcha_error'  => $captcha_error
  );
 }

 echo json_encode($data);
}

?>
