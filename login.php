
<?php



//Afficher formulaire
// traiter le formulaire
//verifier le formulaire
// ecrire le formulaire sur la bdd
require 'config/config.php';
require 'views/partials/header.php';

$email = $password = null;

if(!empty($_POST)) {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    $query = $db->prepare('SELECT * FROM users WHERE email = :email OR pseudo = :email');
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    if($user) 
    {

        $isValid = password_verify($password,$user['password']);

        if($isValid)
        {
            $_session['user'] = [
                'pseudo' =>$user['pseudo'],
                'email' =>$user['email'],
            ];
        }
        else{
            $error ='mot de pass invalide';
        }

    }
    else{
        $error ='mot de pass invalide';//pour qu on ne sache pas si le loguin existe
    }
    
    
}

?>
<div class="container">
    <form action="" method="POST">
        <label for="">Email</label>
        <input type="email" name="email" id="">

        <label for="">Pseudo</label>
        <input type="text" name="pseudo" id="">

        <label for="">Mot de passe</label>
        <input type="password" name="password" id="">

        <button class="btn btn-primary">Envoyer</button>
    </form>
</div>


<?php
require 'views/partials/footer.php';