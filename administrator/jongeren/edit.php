<?php
include_once '../../database.php'; 
session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../../index.php');
}else{
    if(isset($_GET['id'])){
        $user = new DB('localhost','root','','jongerenkansrijker','utf8mb4');                 
        
        $user->show_detail($_GET['id']);
        if (isset($_POST['edit_form'])){
            /* Putting the fieldnames from the form in the array*/
            $fieldnames = array('voornaam', 'achternaam', 'email', 'geboortedatum', 'inschrijfdatum');

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
            else{
                $voornaam = $_POST['voornaam'];
                $tussenvoegsel = $_POST['tussenvoegsel'];
                $achternaam = $_POST['achternaam'];
                $email = $_POST['email'];
                $geboortedatum = $_POST['geboortedatum'];
                $inschrijfdatum = $_POST['inschrijfdatum'];
                $id = $_GET['id'];
                $edit = new DB('localhost','root','','jongerenkansrijker','utf8mb4'); 

                $edit->edit_jongere($voornaam, $tussenvoegsel, $achternaam, $email, $geboortedatum, $inschrijfdatum, $id);
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
    <title>Jongeren Overzicht - Adminstrator</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <?php include "../../assets/require/styles.php";?>

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
                    <a href="../index.php"><img src="../../assets/logo/logoJKS.png" alt="logo" width="200" height="80"></a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="jongeren.php">Jongeren</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="../activiteiten/activiteiten.php">Activiteiten</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="../admin/administrator.php">Adminstrator</a>
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
    
    <main role="main" class="container">
        <center>
            <h4 class="company-title">Instituut Jongeren Kansrijker</h4>
        </center>
        <hr>
        <center>
            <h2>Jongere Wijzigen</h2>
        </center>
        <hr>
        <form action="" method="POST">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="voornaam" value="<?php echo $user->voornaam;?>" maxlength="60" placeholder="Voornaam" required/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="tussenvoegsel" value="<?php echo $user->tussenvoegsel;?>"  maxlength="60" placeholder="Tussenvoegsel">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="achternaam" value="<?php echo $user->achternaam;?>" maxlength="60" placeholder="Achternaam" required/>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="col">
                    <input type="email" class="form-control" name="email" value="<?php echo $user->email;?>"   maxlength="60" placeholder="email" required/>
                </div>
                <div class="col">
                    <input type="date" class="form-control" name="geboortedatum" value="<?php echo date($user->geboortedatum);?>"  maxlength="60" required/>
                </div>
                <div class="col">
                    <input type="date" class="form-control" name="inschrijfdatum" value="<?php echo date($user->inschrijfdatum);?>"  maxlength="60" required/>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <input type="submit" name="edit_form" class="btn btn-warning mt-3"  value="wijzigen">
                        <a class="btn btn-primary mt-3" href="jongeren.php">Terug</a>
                </div>
            </div>
        </form>

    </main>

        <?php include "../../assets/require/scripts.php";?>
</body>
</html>