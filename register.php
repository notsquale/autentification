<?php

//Afficher formulaire
// traiter le formulaire
//verifier le formulaire
// ecrire le formulaire sur la bdd
require 'config/config.php';

require 'views/partials/header.php';


$errors = [];
$email = $pseudo = null;
if(!empty($_POST))
{
    foreach($_POST as $field => $value)
    {
        $$field = sanitize($value); // double $$ syntaxe racourcie 
        var_dump($$field);
    }

    /* $email = sanitize($_POST['email']);
    $pseudol = sanitize($_POST['pseudo']);
    $password = sanitize($_POST['password']);
    $cf-password = sanitize($_POST['cf-password']);
 */



    if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $errors['email'] = 'email non valide' ; 
    }

    if (empty($pseudo)) 
    {
        $errors['pseudo'] = 'pseudo non valide' ; 
    }

    if(preg_match('/(.){8,}/', $password)) {
        $errors['password'] = 'mot de passe trop court';
    }

    if(preg_match('/[0-9]+/', $password)) {
        $errors['password'] = 'mot de passe doit contenir au moin 1 chiffre';
    }

    if(preg_match('/[^a-zA-Z0-9 ]+/', $password)) {
        $errors['password'] = 'au moins un caractere special';
    }
    if($password !== $cfPassword) {

        $errors['password'] = 'les 2 mots de passe doivent correspondre';
    }


    //todo verifier que l' email saisi  n est pas en BDD , si c ' est le cat , on ajoute une erreur


    //mieux , rejouter un evenement keyup sur l email , vaire une requette ajax jsonecode sun un autre php, 
    //qui verifie que l email saisi n' est pas dans la bdd
    //une fois la requette terminée $(alax)done , qui renvoie un bool , et on affiche email utilisé ou dispo
    //mettre un spinner pendant la requette alax

    



    $query = $db->prepare( "INSERT INTO user (email,pseudo,password)
    VALUES (:email, :pseudo, :password)");

    
    if(empty($errors)) 
    {

            var_dump($errors);

            $password = password_hash($password, PASSWORD_DEFAULT);
            $query->execute([
            'email' => $email,
            'pseudo' => $pseudo,
            'password' => $password,
        ]);
        echo "INSERT INTO user (email, pseudo, password)
            VALUES ($email, $pseudo, $password)";


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
    <label for="">Email</label>
    <input type="email" name="email" id="">

    <label for="">Pseudo</label>
    <input type="text" name="pseudo" id="">

    <label for="">Mot de passe</label>
    <input type="password" name="password" id="">

    <label for="">Confirmer le mot de passe</label>
    <input type="password" name="cfPassword" id="">

    <button class="btn btn-primary">Envoyer</button>
</form>
</div>


<?php
require 'views/partials/footer.php';