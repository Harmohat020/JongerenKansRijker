<?php
include_once '../../database.php'; 

session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../../index.php');
}else{
    if(isset($_GET['id'])){
        $admin = new DB('localhost','root','','jongerenkansrijker','utf8mb4');                 
        
        $admin->show_admin_detail($_GET['id']);

        /* Checking if the form is succesfully submitted */
        if (isset($_POST['edit_form'])){
            /* Putting the fieldnames from the form in the array*/
            $fieldnames = array('fname', 'lname', 'email');

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
            }
            /*If there is not a error, data will be inserted in the database */
            else {
                $edit = new DB('localhost','root','','jongerenkansrijker','utf8mb4');

                $voornaam = ucwords($_POST['fname']);
                $tussenvoegsel = $_POST['tussenvoegsel'];
                $achternaam = ucwords($_POST['lname']);
                $email = $_POST['email'];
                $id = $_GET['id'];
                
                $edit->update_admin($voornaam, $achternaam, $tussenvoegsel, $email, $id);

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
    <title>Administrator Edit - Adminstrator</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Custom Styles -->
    <link rel="stylesheet" href="../../assets/styles/administrator/style.css">
    <style>
    body {
        min-height: 75rem;
        padding-top: 4.5rem;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home<span class="sr-only"></span></a>
                </li>
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
        <h2>Edit Administrator</h2>
    </center>
    <hr>

    <main role="main" class="container">
        <form class="form form-register" action="" method="post">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="fname" value="<?php echo $admin->voornaam; ?>"  maxlength="60" placeholder="Voornaam" required/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="tussenvoegsel" value="<?php echo $admin->$tussenvoegsel; ?>"  maxlength="60" placeholder="Tussenvoegsel"/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="lname" value="<?php echo $admin->achternaam; ?>"  maxlength="60" placeholder="Achternaam" required/>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="col">
                    <input type="email" class="form-control" name="email" value="<?php echo $admin->email; ?>" maxlength="60" placeholder="email" required/>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <input type="submit" name="edit_form" class="btn btn-warning mt-3"  value="wijzigen">
                        <a class="btn btn-primary mt-3" href="administrator.php">Terug</a>
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