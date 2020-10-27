<?php
session_start();
 
include_once 'database.php';

/*Setting var $message empty */
$message = "";

/* Check if form is submitted succesfully */
if (isset($_POST['formLogin'])){

  /*Getting the message from database.php */
  $message = $_SESSION['message'];
  
  /* Putting the fieldnames of the loginform into a array */
  $fieldnames = ['email', 'password'];

  $error = false;

  /* Looping the fieldnames in the $_POST[] */
  foreach ($fieldnames as $data) {
    if(empty($_POST[$data])){
        $error = true;
    }    
  }

  /* If a fieldname is empty message will be shown */
  if ($error) {  
    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'All fields are required' .'</div>';     
  }
  else{
    $login = new DB('localhost','root','','jongerenkansrijker','utf8mb4');

    $email = $_POST['email'];
    $password = $_POST['password'];

    $login->login($email, $password);
  }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title> 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Custom Styles -->
    <link rel="stylesheet" href="assets/styles/login/style.css">
</head>
<body>
<?php echo $message; ?>
  <div class="card">
     <div class="card-body">
        <form action="" method="POST">
          <center>  
            <h2>JongerenKansRijker</h2>
          </center>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" autofocus required/>
          </div>
          <div class="form-group">
            <label>Wachtwoord</label>
            <input type="password" class="form-control" name="password" required/>
          </div>
          <input type="submit" class="btn btn-primary"  name="formLogin" value="inloggen"/>
        </form>
      </div>
  </div>
 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>

