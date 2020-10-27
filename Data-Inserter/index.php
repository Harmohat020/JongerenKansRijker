<?php
require_once('src/autoload.php');
try{
    $count = 1;
    $faker = Faker\Factory::create('en_GB');;
    //Connecting MySQL Database
    $pdo  = new PDO('mysql:host=localhost;dbname=jongerenkansrijker', 'root', '', array(
        PDO::ATTR_PERSISTENT => true
    ));
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
     
    
    //Insert the data
    $sql = "INSERT INTO account_administrator(ID, email, password, usertype_id)
    VALUES(NULL, :email, :password, 1);";

    $stmt = $pdo->prepare($sql);

    for ($i=0; $i < $count; $i++) {
        $stmt->execute(
            [   
                ':email' => '2101819@talnet.nl', 
                ':password' => password_hash('admin123', PASSWORD_DEFAULT)
            ]
        );
    }

    /* Getting the last inserted ID value */
    $ID = $pdo->lastInsertId();

    echo $ID;
                
    $sql2 = "INSERT INTO administrator(ID, voornaam, tussenvoegsel, achternaam, account_id)
    VALUES(NULL, :voornaam, :tussenvoegsel, :achternaam, :id);";
         
    $stmt = $pdo->prepare($sql2);

    for ($i=0; $i < $count; $i++) {
        $stmt->execute(
            [
                ':voornaam' => 'Harmohat', 
                ':tussenvoegsel' => '',  
                ':achternaam' => 'Khangura',
                'id' => $ID  
                
            ]
        );
    }
} 
catch(Exception $e){
    echo '<pre>';print($e);echo '</pre>';exit;
}
?>
