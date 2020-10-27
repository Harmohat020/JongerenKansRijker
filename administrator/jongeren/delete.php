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
        $jongere->destroy_jongere($id);
    }

}

?>
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
