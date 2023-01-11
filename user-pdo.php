<?php
    //création de la classe user pdo//
class Userpdo {
    //les attributs
    private $id;
    private $login;
    private $password;
    private $email;
    private  $firstname;
    private  $lastname;

    // The DB//
    private $servername = "localhost";
    private $username_c = "root";
    private $password_c = "";
    private $table_db = "classes";

    private $bdd;
    public function __construct()
    {
        //DB connect//
        try {
            $this->bdd = new PDO("mysql:host=$this->servername;dbname=$this->table_db", $this->username_c, $this->password_c);
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "connected to database <br>";
        }
        catch (PDOException $e){
            echo $e->getmessage ();
        }
    }


    //to check if login exist in the DB//
    public function verif_db($login){
        $stmt = $this->bdd->prepare("SELECT * FROM `utilisateurs` WHERE login = ?");
        $stmt->execute([$login]);

        return ($stmt->rowCount() > 0);
    }


    //to register a new user in DB//
    public function register ($login, $password, $email, $firstname, $lastname){
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $req = $this->bdd->prepare("INSERT INTO `utilisateurs`(`login`, `password`, `email`, `firstname`, `lastname`) VALUES(:login, :password, :email, :firstname, :lastname)");
        $req->execute([":login" =>"$login", ":password" => "$hashPassword", ":email" => "$email", ":firstname" => "$firstname", ":lastname" => "$lastname"]);        
    }


    //method for hide password and allowded connexion//
    public function connect($login, $password){
        
        if (!$this->verif_db($login)) {
            echo "Login does not exist in the database";
            return false;
        }

        $stmt = $this->bdd->prepare("SELECT * FROM `utilisateurs` WHERE login = ?");
        $stmt->execute([$login]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        //catch password in the DB//
        $password_db = $data['password'];
        //check if password hidden//
        if (password_verify($password, $password_db)){
            $_SESSION['id'] = $data['id'];

            $this->id = $data['id'];
            $this->login = $data['login'];
            $this->email = $data['email'];
            $this->firstname = $data['firstname'];
            $this->lastname = $data['lastname'];
            
            echo "$login is connected";

            // var_dump($data);

            return true;
            
        }else{ 
            echo "Password is not correct";
            return false;
        }
    }
        //method to modify profil of a user in DB//
       public function update($login, $password, $email, $firstname, $lastname){
        $req_updt = $this->bdd->prepare("UPDATE `utilisateurs` SET login=?, password=?, email=?, firstname=?, lastname=? WHERE id = ?");
        $req_updt->execute([$login, $password, $email, $firstname, $lastname, $this->id]);
       }
    //method to deconnect//
    public function disconnect(){
       session_unset();//détruit les variables de la session en cours//
       session_destroy();//détruit la session en cours
    }

    //method to delete a user//
    public function delete(){
        $req_delet = $this->bdd->prepare("DELETE FROM `utilisateurs` WHERE login=?");
        $req_delet->execute(["$this->login"]);

        $this->disconnect();
    }

    // methode pour verify that a user is connected
    public function isConnected(){
        if (isset($_SESSION['id'])) :
            return true;
        else:
            return false;
        endif;
    }



    //  Method to display user info
    public function getAllInfos(){
        $allInfos = [];


        if ($this->isConnected()) {
            $allInfos = array(
                "id" => $this->id,
                "login" => $this->login,
                "email" => $this->email,
                "firstname" => $this->firstname,
                "lastname" => $this->lastname,
            );
        }

        return $allInfos;

    }


    //  Method to return Login
    public function getLogin(){
        return $this->login;
    }

    //  Method to return l'Email
    public function getEmail(){
        return $this->email;
    }

    //  Method to  return Firstname
    public function getFirstname(){
        return $this->firstname;

    }


    //  Method to return lLasttname.
    public function getLastname(){
        return $this->lastname;
    }
}

?>