<?php 

require 'config/config.php';

require 'views/partials/header.php';


//on verifie l axitence du token
$query = $db->prepare('SELECT * FROM reset_token WHERE token = :token');

$query->execute(['token' => $_GET['token']]);
$token = $query->fetch();

//si il n 'existe pas
if(!$token) {
    http_response_code(404);
    die(404);
}
//si il est  trop vieux
$now = new DateTime();
$expitedAt = new DateTime($token['expired_at']);
if($now>$expitedAt){


    //@todo faudrait lvirer le token de la bdd

    $db->query('DELETE FROM reset_token WHERE id = '.$token['id']); //done
    http_response_code(404);
    die(404);
}
//si il existe 

$errors = [];

if(!empty($_POST)) {

    $password = sanitize($_POST['password']);
    $cfPassword = sanitize($_POST['cfPassword']);

    //verifier password

    if(!preg_match('/(.){8,}/', $password)) {
        $errors['password_length'] = 'mot de passe trop court';
    }

    if(!preg_match('/[0-9]+/', $password)) {
        $errors['password_num'] = 'mot de passe doit contenir au moin 1 chiffre';
    }

    if(!preg_match('/[^a-zA-Z0-9 ]+/', $password)) {
        $errors['password_spec'] = 'au moins un caractere special';
    }
    if($password !== $cfPassword) {

        $errors['password_match'] = 'les 2 mots de passe doivent correspondre';
    }




    //si password ok

    if(empty($errors)) 
    {

          $password = password_hash($password , PASSWORD_DEFAULT);

        //$query = $db->prepare('UPDATE users SET password = :password');//pour ne reseter qu 1 seul user

        $query = $db->prepare('UPDATE users SET password = :password WHERE id = :id');
        $query->execute([
            'password' => $password,
            'id' => $token['id_user'],//pour ne reseter qu 1 seul user
            ]);

        $db->query('DELETE FROM reset_token WHERE id = '.$token['id']);  


        header('Location: '.$baseUrl);

    }


    



}

?>
<div class="container">


    <?php if(!empty($errors)) { ?>

    <div class="alert alert-danger">
        <?php foreach  ($errors as $field => $error) { ?>

            <p><?= $field?> : <?= $error?></p>

            <?php }     
        ?>
    </div>
    <?php
    } ?>

    <form action="" method="POST">
        <label for="password">nouveau password</label>
        <input type="password" name="password" id="password">

        <label for="cfPassword">confirmer nouveau password</label>
        <input type="password" name="cfPassword" id="cfPassword">

        
        <button class="btn btn-primary">Envoyer</button>
    </form>
</div>


<?php


require 'views/partials/footer.php';
