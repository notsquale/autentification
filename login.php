
<?php



//Afficher formulaire
// traiter le formulaire
//verifier le formulaire
// ecrire le formulaire sur la bdd
require 'config/config.php';
require 'views/partials/header.php';

$errors = $email = $password = null;

if(!empty($_POST)) {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    $query = $db->prepare('SELECT * FROM users 
    WHERE email = :email OR pseudo = :email');
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    if($user) 
    {

        $isValid = password_verify($password,$user['password']);

        if($isValid)
        {
            $_SESSION['user'] = [//Super globales en upper case  sinon bug
                'pseudo' =>$user['pseudo'],
                'email' =>$user['email'],
            ];
            redirect(); //renvoie vers le home
        }
        else{
            $errors ='mot de pass invalide hahaha';
        }

    }
    else{
        $errors ='mot de pass invalide hohoho';//pour qu on ne sache pas si le loguin existe
    }
    
    
}

?>
<div class="container">
    <?= $errors; ?>


    <form action="" method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" id="">

        <!-- <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id=""> -->

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="">

        <button class="btn btn-primary">connexion</button>
    </form>
</div>


<?php
require 'views/partials/footer.php';