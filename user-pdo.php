<?php
    //création de la classe user pdo//
class userpdo{
    //les attributs
    private $id;
    private $login;
    private $password;
    private  $firstname;
    private  $lastname;

    // The DB//
    private $servername = "localhost";
    private $username_c = "root";
    private $password_c = " ";
    private $table_db = "classes";

    private $bdd;
    public function __construct()
    {
        //DB connect//
        try {
            $this->bdd = new PDO("mysql:host=$this->servername;dbname=$this->table_db", $this->username_c, $this->password_c);
        }
        catch (PDOException $e){
            echo $e->getmessage ();
        }
    }
        //to check if login exist in the DB//
        public function verif_db($login){
            $data = $this->bdd->prepare("SELECT * FROM `utilisateurs` WHERE login=?");
            $data->execute(["login"]);
            return $data->fetchAll(PDO::FETCH_ASSOC);//if return is empty object cause the login doesn't exist//
        }
        //to register a new user in DB//
        public function register ($login, $password, $email, $firstname, $lastname){
            $req = $this->bdd->prepare("INSERT INTO `utilisateurs`(`login`, `password`, `email`, `firstname`, `lastname`) VALUES(:login, :password, :email, :firstname, :lastname);");
            $req->execute([":login" =>"$login", ":password" => "$password", ":email" => "$email", ":firstname" => "$firstname", ":lastname" => "lastname"]);        
        }
        //method for hide password and allowded connexion//
        public function connect($login, $password){
        //search user in the DB//
        $data = $this-> verif_db($login);
        $coun = count($data); //count number//
        if ($coun === 1):
            //catch password in the DB//
            $password_db = $data [0]['password'];
            //check if password hidden//
            if (password_verify($password, $password_db)){
                return true;
            }else{ return false;
            }
        endif;
    }
        //method to modify profil of a user in DB//
       public function update($login, $password, $email, $firstname, $lastname, $login_ancien){
        $req_updt = $this->bdd->prepare("UPDATE `utilisateurs` SET login=?, password=?, email=?, firstname=?, lastname=? WHERE logon = '$login_ancien';");
        $req_updt->execute(["$login", "$password", "$email", "$firstname", "$lastname"]);
       }
       //method to deconnect//
       public function disconnect(){
       $_SESSION = array();//ecrasser la session//
       session_unset();//détruit les variables de la session en cours//
       session_destroy();//détruit la session en cours
    }
    //method to delete a user//
    public function delete($login){
        $req_delet = $this->bdd->prepare("DELETE FROM `utilisateurs` WHERE login=?;");
        $req_delet->execute(["login"])
    }
        
    }



}
?>