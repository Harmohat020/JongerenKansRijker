<?php
include_once '../../database.php'; 

session_start();

$user_row = $_SESSION['row'];

if ($user_row[0]->type != 'administrator') {
    header('Location: ../../index.php');
}else{
    if(isset($_GET['id'])){
        $admin = new DB('localhost','root','','jongerenkansrijker','utf8mb4');

        $id = $_GET['id'];

        $admin->destroy_admin($id);
    }

}
?>
