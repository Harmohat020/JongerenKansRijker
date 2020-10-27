<?php
include_once '../../database.php'; 
session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../../index.php');
}else{
    if(isset($_GET['id'])){
        $activiteit = new DB('localhost','root','','jongerenkansrijker','utf8mb4');                 
        
        $activiteit->show_activiteit_detail($_GET['id']);

        if (isset($_POST['edit_form'])){
            $error = false;
            
            if(empty($_POST['naam'])){
                $error = true;
            }
            /* If a fieldname is empty error message will be shown */
            if ($error) {  
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'All fields are required' .'</div>'; 
            }
            else{   
                $edit = new DB('localhost','root','','jongerenkansrijker','utf8mb4'); 

                $naam = $_POST['naam'];
                $id = $_GET['id'];

                $edit->edit_activiteit($naam, $id);
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
                    <!-- <a class="nav-link active" href="index.php">Home<span class="sr-only"></span></a> -->
                    <a href="../index.php"><img src="../../assets/logo/logoJKS.png" alt="logo" width="200" height="80"></a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../jongeren/jongeren.php">Jongeren</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="activiteiten.php">Activiteiten</a>
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
            <h2>Activiteit Wijzigen</h2>
        </center>
        <hr>
        <form action="" method="POST">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="naam" value="<?php echo $activiteit->naam;?>" maxlength="120" required/>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <input type="submit" name="edit_form" class="btn btn-warning mt-3"  value="wijzigen">
                        <a class="btn btn-primary mt-3" href="activiteiten.php">Terug</a>
                </div>
            </div>
        </form>

    </main>

        <?php include "../../assets/require/scripts.php";?>
</body>
</html>