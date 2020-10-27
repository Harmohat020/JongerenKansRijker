<?php
include_once '../../database.php'; 

session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../../index.php');
}else{
    if(isset($_GET['id'])){
        $jongere = new DB('localhost','root','','jongerenkansrijker','utf8mb4');

        $id = $_GET['id'];
        $jongere->destroy_activiteit($id);
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <?php include "../../assets/require/styles.php";?>

    <!--Custom Styles -->
    <link rel="stylesheet" href="../../assets/styles/administrator/style.css">
</head>
<body>
        <?php include "../../assets/require/scripts.php";?>
</body>
</html>