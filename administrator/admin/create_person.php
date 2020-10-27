<?php
include_once '../../database.php'; 

session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../../index.php');
}else{
    /* Checking if the form is succesfully submitted */
    if (isset($_POST['register_form'])){
        /* Putting the fieldnames from the form in the array*/
        $fieldnames = array('fname', 'lname', 'email', 'pwd', 'repeat-pwd');

        $error = false;
        /* Looping the fieldnames in the $_POST[] */
        foreach ($fieldnames as $data) {
            if(empty($_POST[$data])){
                $error = true;
            }    
        }
        /* If a fieldname is empty error message will be shown */
        if ($error) {  
            echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'All fields are required' .'</div>'; 
            
            error_log('X - Add User Failed: email: '.$email.' - '.date("h:i:sa").' ['.$ip_address."]\n", 3, '../logs/admin/log_'.date("d-m-Y").'.log');

        }
        /*If there is not a error, data will be inserted in the database */
        else {
        $administrator = new DB('localhost','root','','jongerenkansrijker','utf8mb4');

        $voornaam = ucwords($_POST['fname']);
        $tussenvoegsel = $_POST['tussenvoegsel'];
        $achternaam = ucwords($_POST['lname']);
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        $pwd_repeat = $_POST['repeat-pwd'];  
            /* If password is not the same error will be shown */
            if ($password != $pwd_repeat) {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Password is not the same' .'</div>';

                error_log('X - Add User Failed: email: '.$email.' - '.date("h:i:sa").' ['.$ip_address."]\n", 3, '../logs/admin/log_'.date("d-m-Y").'.log');

            }else{
                $administrator->create_administrator($email, $password, $voornaam, $tussenvoegsel, $achternaam);

                error_log('✓ - Add User Success: email: '.$email.' - '.date("h:i:sa").' ['.$ip_address."]\n", 3, '../logs/admin/log_'.date("d-m-Y").'.log');
            }

        } 
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Overzicht - Adminstrator</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Custom Styles -->
    <link rel="stylesheet" href="../../assets/styles/administrator/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <!-- <a class="nav-link active" href="index.php">Home<span class="sr-only"></span></a> -->
                    <a href="../index.php"><img src="../../assets/logo/logoJKS.png" alt="logo" width="200" height="80"></a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../jongeren/jongeren.php">Jongeren</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="../activiteiten/activiteiten.php">Activiteiten</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="administrator.php">Adminstrator</a>
                </li>   
                <li class="nav-item">
                    <a class="nav-link" href="../jongeren_activiteiten/jongeren_activiteiten.php">Jongeren Activiteiten</a>
                </li>    
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                         <a class="dropdown-item " href="../logout.php">Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <center>
        <h4 class="company-title">Instituut Jongeren Kansrijker</h4>
    </center>
    <hr>
    <center>
        <h2>Nieuwe Administrator</h2>
    </center>
    <hr>

    <main role="main" class="container">
        <form class="form form-register" action="" method="post">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="fname"   maxlength="60" placeholder="Voornaam" required/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="tussenvoegsel"  maxlength="60" placeholder="Tussenvoegsel"/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="lname" maxlength="60" placeholder="Achternaam" required/>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="col">
                    <input type="email" class="form-control" name="email"   maxlength="60" placeholder="email" required/>
                </div>
                <div class="col">
                    <input type="password" class="form-control" name="pwd" maxlength="60" placeholder="Wachtwoord" required/>
                </div>
                <div class="col">
                    <input type="password" class="form-control" name="repeat-pwd" maxlength="60" placeholder="Herhaal Wachtwoord" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <input type="submit" class="btn btn-primary mt-3" name="register_form" value="Toevoegen"/>
                </div>
            </div>
        </form>  
        <hr> 
    </main>
    
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>