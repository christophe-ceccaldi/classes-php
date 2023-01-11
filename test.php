<?php

require 'user-pdo.php';

session_start();

$user = new Userpdo();

$login = "rim";
$password = 'azerty';
$email = 'rim@lolo.com';
$firstname = 'Rim';
$lastname = 'Ukachi';


// $user->register($login, $password, $email, $firstname, $lastname);

$user->connect($login, $password);

var_dump($user->isConnected());

echo "<br>" . "============================:" . "<br>";
echo "Testing getallInfos() method :" . "<br>";
var_dump($user->getAllInfos());
echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";


echo "<br>" . "============================:" . "<br>";
echo "Testing getLogin() method :" . "<br>";
var_dump($user->getLogin());
echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";



echo "<br>" . "============================:" . "<br>";
echo "Testing getEmail() method :" . "<br>";
var_dump($user->getEmail());
echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";



echo "<br>" . "============================:" . "<br>";
echo "Testing getFirstname() method :" . "<br>";
var_dump($user->getFirstname());
echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";


echo "<br>" . "============================:" . "<br>";
echo "Testing getLastname() method :" . "<br>";
var_dump($user->getLastname());
echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";



// echo "<br>" . "============================:" . "<br>";
// echo "Testing disconnect() method :" . "<br>";

// $user->disconnect();

// if($user->isConnected() == FALSE) {
//     echo "User has been disconnected!" . "<br>";
// }

// echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";


// echo "<br>" . "============================:" . "<br>";
// echo "Testing disconnect() method :" . "<br>";
// $user->delete();

// if($user->verif_db($login) == FALSE) {
//     echo "User has been deleted!" . "<br>";
// }

// echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";


echo "<br>" . "============================:" . "<br>";
echo "Testing update() method :" . "<br>";
$user->update($login, $password, $email, $firstname, "Moghlali");
echo "+++++++++++++++++++++++++:" . "<br>" . "<br>";
