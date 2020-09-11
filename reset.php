<?php 

require 'config/config.php';

require 'views/partials/header.php';



$query = $db->prepare('SELECT * FROM reset_token WHERE token = :token');

$query->execute(['token' => $_GET['token']]);
$token = $query->fetch();


if(!$token) {
    http_response_code(404);
    die(404);
}

$now = new DateTime();
$expitedAt = new DateTime($token['expired_at']);
if($now>$expitedAt){
    //@todo faudrait lvirer le token de la bdd
    http_response_code(404);
    die(404);
}

$password = null;
if(!empty($_POST)) {

    $password = sanitize($_POST['password']);
    $cfPassword = sanitize($_POST['sfPassword']);

    //verifier password

    $password = password_hash($password , PASSWORD_DEFAULT);
    $query = $db->prepare('UPDATE users SET password = :password');
    $query->execute(['password' => $password]);

    $db->query('DELETE FROM reset_token WHERE id = '.$token['id']);



}

?>
<div class="container">
    <form action="" method="POST">
        <label for="password">entrez votre nouveau password</label>
        <input type="password" name="password" id="password">

        <label for="cfPassword">entrez votre nouveau password</label>
        <input type="password" name="cfPassword" id="cfPassword">

        
        <button class="btn btn-primary">Envoyer</button>
    </form>
</div>


<?php


require 'views/partials/footer.php';
