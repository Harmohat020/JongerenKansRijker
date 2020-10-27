<?php
include_once '../../database.php'; 

session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../../index.php');
}else{
    $overzicht = new DB('localhost','root','','jongerenkansrijker','utf8mb4');
    $overzicht->show_activiteit_jongere();

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Jongeren Activiteiten - Adminstrator</title>
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
                    <a class="nav-link" href="../activiteiten/activiteiten.php">Activiteiten</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="../admin/administrator.php">Adminstrator</a>
                </li>      
                <li class="nav-item">
                    <a class="nav-link active" href="jongeren_activiteiten.php">Jongeren Activiteiten</a>
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
            <h2>Activiteiten Overzicht</h2>
        </center>
        <hr>
        <div class="pull-right">
            <a class="btn btn-success mb-3" href="add_activiteit_jongere.php">Activiteit Jongere Toevoegen</a>
        </div>

        <table class="table table-striped" id="overzicht">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Voornaam</th>
                        <th scope="col">tussenvoegsel</th>
                        <th scope="col">Achternaam</th>
                        <th scope="col">inschrijfdatum</th>
                        <th scope="col">activiteit</th>
                        <th scope="col">startdatum</th>
                        <th scope="col">afgerond</th>
                    </tr>
                </thead>
                <tbody>
                <?php   
                if (empty($overzicht->array)):
                    echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Geen data beschikbaar' .'</div>';    
                else:
                    foreach ($overzicht->array as $array): 
                        foreach ($array as $jongere): ?>
                    <tr>
                        <td><?php echo $jongere['id'];?></td>
                        <td><?php echo $jongere['roepnaam'];?></td>
                        <td><?php echo $jongere['tussenvoegsel'];?></td>
                        <td><?php echo $jongere['achternaam'];?></td>
                        <td><?php echo $jongere['inschrijfdatum'];?></td>
                        <td><?php echo $jongere['activiteit'];?></td>
                        <td><?php echo $jongere['startdatum'];?></td>
                        <td><?php 
                            if ($jongere['afgerond'] === '0') {
                                echo 'Nee';
                            }else{
                                echo 'Ja';
                            }
                        ?></td>
                    </tr> 
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <button id="csv-file-exp" class="noExl btn btn-outline-success">export excel</button>
        </main>
  
        <?php include "../../assets/require/scripts.php";?>
  </body>
</html>