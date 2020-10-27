<?php
class DB{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $charset;
    private $pdo;

    public function __construct($host, $user, $pass, $db, $charset){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
        $this->charset = $charset; 
        
        try{
            $dsn = 'mysql:host='. $this->host.';dbname='.$this->db.';charset='.$this->charset;
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        }
        catch(\PDOException $e){
            echo "Connection Failed: ".$e->getMessage();
        }
      
    }
    public function create_administrator($email, $password, $voornaam, $tussenvoegsel, $achternaam){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction(); 

            //email check if exists
            $sqlCheckUser = "SELECT email FROM account_administrator";

            $queryCheckUser = $this->pdo->prepare($sqlCheckUser);

            $queryCheckUser->execute();

            // is an associative array 
            $resultCheckUser = $queryCheckUser->fetchAll(PDO::FETCH_OBJ);
             
            $emailChecker = [];
    
            foreach ($resultCheckUser as $checkUser) {
                array_push($emailChecker, $checkUser->email);
            }
             
            /* Check if Email and Username already exists in database */
            if (in_array($email, $emailChecker)) {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Email Already Exists' .'</div>';    
            }

            $pwd = password_hash($password, PASSWORD_DEFAULT);  

            $sql = "INSERT INTO account_administrator(ID, email, password, usertype_id)
            VALUES(NULL, :email, :password, 1);";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'email' => $email,
                'password' => $pwd
            ]);

            $ID = $this->pdo->lastInsertId();

            $sql2 = "INSERT INTO administrator(ID, voornaam, tussenvoegsel, achternaam, account_id)
            VALUES(NULL, :voornaam, :tussenvoegsel, :achternaam, :id);";

            $query = $this->pdo->prepare($sql2);

            $query->execute([
                'voornaam' => $voornaam,
                'tussenvoegsel' => $tussenvoegsel,
                'achternaam' => $achternaam,
                'id' =>$ID
            ]);

            /* Commit the changes */
            $this->pdo->commit();

            /* Prevents that data is always added to the table during refresh */
            header("Location: administrator.php");

            exit;
            

        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }
    public function login($email, $password){
        try {        
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction(); 

            $sql = "SELECT voornaam, tussenvoegsel, achternaam, email, password, type
            FROM administrator
            INNER JOIN account_administrator
            ON administrator.account_id = account_administrator.ID
            JOIN usertype
            ON account_administrator.usertype_id = usertype.ID
            WHERE email = :email;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'email' => $email
            ]);

            /*Fetching rows */
            $rows = $query->fetchAll(PDO::FETCH_OBJ);
                
            foreach ($rows as $row) {
                $rowPassword = $row->password;
            }

            /* whether ip is from share internet */
            if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                $ip_address = $_SERVER['HTTP_CLIENT_IP'];
            }
            /* whether ip is from proxy */
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            /* whether ip is from remote address */
            else{
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }

            if (count($rows) > 0) { 
                $verify = password_verify($password, $rowPassword);
                
                session_start();
                if ($verify) {
                    if($rows[0]->type === 'administrator'){
                        $_SESSION['row'] = $rows;
                        $_SESSION['email'] = $rows[0]->email;
                        
                        header("Location: administrator/"); 
                    }
                }
                else {
                    /*If email is right but pasword is wrong, error message will be shown,
                    and message will be logged to logs/ */
                    $message = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Invalid email or Password' .'</div>';
                    $_SESSION['message'] = $message;

                    error_log('X - Login Failed: username: '.$email.' '.date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/login/log_'.date("d-m-Y").'.log');                        }        
    
            }else {
                /*If email & password are wrong, error message will be shown,
                and message will be logged to logs/ */
                $message = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Invalid email or Password' .'</div>';
                $_SESSION['message'] = $message;
                error_log('X - Login Failed: username: '.$email.' '.date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/login/log_'.date("d-m-Y").'.log');
             } 



        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }
    public function create_jongere($voornaam, $tussenvoegsel, $achternaam, $email, $geboortedatum, $inschrijfdatum){
        try {
             /* Begin a transaction, turning off autocommit */
             $this->pdo->beginTransaction(); 
 
             $sql = "INSERT INTO jongere(ID, roepnaam, tussenvoegsel, achternaam, email, geboortedatum, inschrijfdatum)
             VALUES(NULL, :roepnaam, :tussenvoegsel, :achternaam, :email, :geboortedatum, :inschrijfdatum);";
 
             $query = $this->pdo->prepare($sql);
 
             $query->execute([
                 'roepnaam' => $voornaam,
                 'tussenvoegsel' => $tussenvoegsel,
                 'achternaam' => $achternaam,
                 'email' => $email,
                 'geboortedatum' => $geboortedatum,
                 'inschrijfdatum' => $inschrijfdatum
             ]);

             /* Commit the changes */
             $this->pdo->commit();
 
             /* Prevents that data is always added to the table during refresh */
             header("Location: jongeren.php");

             exit;
        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function show_jongere(){
        try {
            /* Begin a transaction, turning off autocommit*/
            $this->pdo->beginTransaction();

            $sql = "SELECT * FROM jongere;";

            $query = $this->pdo->prepare($sql);

            $query->execute();

            /*Fetching rows */
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($rows) > 0) {
                $this->array = [];
                array_push($this->array, $rows);
            }
                
        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
        
    }
    public function create_activiteit($activiteit){
        try {
            /* Begin a transaction, turning off autocommit*/
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO activiteit(ID, activiteit) VALUES (NULL, :activiteit);";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'activiteit' => $activiteit
            ]);

            /* Commit the changes */
            $this->pdo->commit();

            header('Location: activiteiten.php');

        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }

    }

    public function show_activiteit(){
        try {
            /* Begin a transaction, turning off autocommit*/
            $this->pdo->beginTransaction();

            $sql = "SELECT * FROM activiteit;";

            $query = $this->pdo->prepare($sql);

            $query->execute();

            /*Fetching rows */
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($rows) > 0) {
                $this->array = [];
                array_push($this->array, $rows);
            }

        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    
    }

    public function add_activiteit_jongere($jongereID, $activiteitID, $afgerond, $startdatum){
        try {
            /* Begin a transaction, turning off autocommit*/
            $this->pdo->beginTransaction();

            /* Check if jongere/activiteit exists or not*/
            $check  = "SELECT jongere.id as jongereID, activiteit.id as activiteitID  FROM jongere INNER JOIN activiteit;";

            $querycheck = $this->pdo->prepare($check);

            $querycheck->execute();

            $result = $querycheck->fetchAll(PDO::FETCH_OBJ);

            $checkerJongere = [];
            $checkerActiviteit  = [];

            foreach ($result as $jongere) {
                array_push($checkerJongere, $jongere->jongereID);
                array_push($checkerActiviteit, $jongere->activiteitID);
            }

            if (!in_array($jongereID, $checkerJongere) AND !in_array($activiteitID, $checkerActiviteit)) {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Jongere en Activiteit bestaan niet' .'</div>';    
            }elseif(!in_array($activiteitID, $checkerActiviteit)) {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Activiteit Bestaat niet' .'</div>';    
            }elseif (!in_array($jongereID, $checkerJongere) ) {
                echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Jongere Bestaat niet' .'</div>';    
            }
            else{
                $sql = "INSERT INTO jongereactiviteit(ID, jongereID, activiteitID, startdatum, afgerond)
                VALUES(NULL, :jongereID, :activiteitID, :startdatum, :afgerond);";
    
                $query =  $this->pdo->prepare($sql);
    
                $query->execute([
                    'jongereID' => $jongereID,
                    'activiteitID' => $activiteitID,
                    'afgerond' => $afgerond,
                    'startdatum' => $startdatum
                ]);
    
                /* Commit the changes */
                $this->pdo->commit();
                
                header('Location: jongeren_activiteiten.php');
    
                exit;
            }

         
        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }
    public function show_activiteit_jongere(){
        try {
            /* Begin a transaction, turning off autocommit*/
            $this->pdo->beginTransaction();

            $sql = "SELECT jongereactiviteit.id as id, roepnaam, tussenvoegsel, achternaam, startdatum, afgerond, inschrijfdatum, activiteit FROM jongereactiviteit 
            INNER JOIN jongere on jongereID = jongere.ID INNER JOIN activiteit on activiteitID = activiteit.id;";

            $query = $this->pdo->prepare($sql);

            $query->execute();

            /*Fetching rows */
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($rows) > 0) {
                $this->array = [];
                array_push($this->array, $rows);
            }

        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }

    }

    public function show_detail($id){
        try {
            /* Begin a transaction, turning off autocommit*/
            $this->pdo->beginTransaction();

            $sql = "SELECT * FROM jongere where id = :id;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'id' => $id
            ]);

            $user = $query->fetch(PDO::FETCH_ASSOC);
            
  
            $this->voornaam =  $user['roepnaam'];
            $this->tussenvoegsel =  $user['tussenvoegsel'];
            $this->achternaam =  $user['achternaam'];
            $this->email =  $user['email'];
            $this->geboortedatum  =  $user['geboortedatum'];
            $this->inschrijfdatum =  $user['inschrijfdatum'];

        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function edit_jongere($voornaam, $tussenvoegsel, $achternaam, $email, $geboortedatum, $inschrijfdatum, $id){
        try {
            /* Begin a transaction, turning off autocommit*/
            $this->pdo->beginTransaction();

            $sql = "UPDATE jongere set roepnaam = :roepnaam, tussenvoegsel = :tussenvoegsel, achternaam = :achternaam, email = :email,
            geboortedatum = :geboortedatum, inschrijfdatum = :inschrijfdatum where id =:id;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'roepnaam' => $voornaam,
                'tussenvoegsel' => $tussenvoegsel,
                'achternaam' => $achternaam,
                'email' => $email,
                'geboortedatum' => $geboortedatum,
                'inschrijfdatum' => $inschrijfdatum,
                'id' => $id
            ]);

            /* Commit the changes */
            $this->pdo->commit();

            header('Location: jongeren.php');
    
            exit;

            /* Commit the changes */
            $this->pdo->commit();

        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function destroy_jongere($id){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM jongereactiviteit WHERE jongereID = :id";
     

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'id' => $id
            ]);

            $sql1 = "DELETE FROM jongereinstituut WHERE jongereID = :id;";
            
            $query1 = $this->pdo->prepare($sql1);

            $query1->execute([
                'id' => $id
            ]);

            $sql2 = "DELETE FROM jongere WHERE id = :id;";

            $query2 = $this->pdo->prepare($sql2);

            $query2->execute([
                'id' => $id
            ]);

            /* Commit the changes */
            $this->pdo->commit(); 

            header('Location: jongeren.php');
  
            exit;
        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function destroy_activiteit($id){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            /*check if de id is a FK */
            $check = "SELECT * FROM jongereactiviteit";

            $queryCheck = $this->pdo->prepare($check);

            $queryCheck->execute();

            $result = $queryCheck->fetchAll(PDO::FETCH_OBJ);

            $idChecker = [];

            foreach ($result as $activiteit) {
                array_push($idChecker, $activiteit->activiteitID);
            }

           if (in_array($id, $idChecker)) {
                echo '<div class="alert alert-danger"><a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Deze activiteit is gekoppeld aan een persoon' .'</div>';    
                header('refresh:1;url=activiteiten.php');
            }else{
                $sql = "DELETE FROM activiteit WHERE id = :id;";

                $query = $this->pdo->prepare($sql);

                $query->execute([
                    'id' => $id
                ]);

                /* Commit the changes */
                $this->pdo->commit(); 

              
        
                exit;
           }
        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function edit_activiteit($naam, $id){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql = "UPDATE activiteit SET activiteit = :naam;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'naam' => $naam
            ]);

            /* Commit the changes */
            $this->pdo->commit(); 

            header('Location: activiteiten.php');
        
            exit;
            
        } catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function show_activiteit_detail($id){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql = "SELECT * FROM activiteit WHERE id = :id;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'id' => $id
            ]);

            $activiteit = $query->fetch(PDO::FETCH_ASSOC);

            $this->naam = $activiteit['activiteit'];

        }  catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }
    public function show_admin_all(){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql  = " SELECT  administrator.id as id, voornaam, tussenvoegsel, achternaam, email FROM administrator INNER JOIN account_administrator";
 
            $query = $this->pdo->prepare($sql);
 
            $query->execute();

            /*Fetching rows */
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
            
            print_r($rows);
            if (count($rows) > 0) {
                $this->array = [];
                array_push($this->array, $rows);
            }

        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }
    public function show_admin_detail($id){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql  = "SELECT * FROM administrator INNER JOIN account_administrator WHERE administrator.id = :id;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'id' => $id
            ]);
 
            /*Fetching rows */
            $rows = $query->fetch(PDO::FETCH_ASSOC);
            
            $this->voornaam = $rows['voornaam'];
            $this->tussenvoegsel = $rows['tussenvoegsel'];
            $this->achternaam = $rows['achternaam'];
            $this->email = $rows['email'];
           
        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function update_admin($voornaam, $achternaam, $tussenvoegsel, $email, $id){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql = "UPDATE account_administrator SET email = :email WHERE id = :id;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'email' => $email,
                'id' => $id
            ]);

            $sql1 = "UPDATE administrator set voornaam = :voornaam, tussenvoegsel = :tussenvoegsel, achternaam = :achternaam WHERE id = :id ;";

            $query1 = $this->pdo->prepare($sql1);

            $query1->execute([
                'voornaam' => $voornaam,
                'tussenvoegsel' => $tussenvoegsel,
                'achternaam' => $achternaam,
                'id' => $id
            ]);

            /* Commit the changes */
            $this->pdo->commit(); 

            header('Location: administrator.php');
          
            exit;
        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

    public function destroy_admin($id){
        try {
            /* Begin a transaction, turning off autocommit */
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM administrator USING account_administrator INNER JOIN account_administrator on  account_administrator.id = administrator.account.id WHERE administrator.id = :id;";

            $query = $this->pdo->prepare($sql);

            $query->execute([
                'id' => $id
            ]);

            /* Commit the changes */
            $this->pdo->commit(); 

            header('Location: administrator.php');
      
            exit;
        }catch (PDOException $e) {
            /* Recognize mistake and roll back changes */
            $this->pdo->rollback();
            
            throw $e;
        }
    }

}


?>