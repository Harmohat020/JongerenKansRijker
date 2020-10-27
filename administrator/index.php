<?php
session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Adminstrator</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Custom Styles -->
    <link rel="stylesheet" href="../assets/styles/administrator/style.css">
    <style>
    body {
        min-height: 75rem;
        padding-top: 6.5rem;
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
                    <!-- <a class="nav-link active" href="index.php">Home<span class="sr-only"></span></a> -->
                    <a href="index.php"><img src="../assets/logo/logoJKS.png" alt="logo" width="200" height="80"></a>
                </li>
           </ul>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="jongeren/jongeren.php">Jongeren</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="activiteiten/activiteiten.php">Activiteiten</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="admin/administrator.php">Adminstrator</a>
                </li>      
                <li class="nav-item">
                    <a class="nav-link" href="jongeren_activiteiten/jongeren_activiteiten.php">Jongeren Activiteiten</a>
                </li> 
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                         <a class="dropdown-item " href="logout.php">Log out</a>
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
        <h4>Welcome - <?php echo $user_row[0]->voornaam. ' '.$user_row[0]->tussenvoegsel.' '.$user_row[0]->achternaam;?></h4>
    </center>
    <hr>
  
  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>