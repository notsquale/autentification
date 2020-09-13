<?php

//un formulaire ou on saisit son email

// on verifie que l'email existe

// si oui , on genere un token dans la bdd de 64 carractares random_bytes

//le expired at == heure actuelle +1 et doit etre de tipe datetime


//et le lier a cet user_error

//$bytes = random_bytes;


require 'config/config.php';
require 'views/partials/header.php';

$email = $error = null;

if(!empty($_POST)) {
    $email = sanitize($_POST['email']);

    $query = $db->prepare('SELECT * FROM users WHERE email = :email ');
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    if($user) 
    {
        $token = bin2hex(random_bytes(32));
        $expireAt = (new DateTime())->add(new DateInterval('PT1H'));
        //var_dump($token);
        //var_dump($expireAt);
        $query = $db->prepare('INSERT INTO reset_token(token , expired_at, id_user)
        VALUES(:token, :expired_at, :id_user)');
        $query->execute([
            'token' => $token,
            'expired_at' => $expireAt->format('Y-m-d H:i:s'),
            'id_user' => $user['id'],
        ]);

        //echo $baseUrl.'/reset.php?token='.$token;
        $reset = '/reset.php?token='.$token;

        redirect($reset);

    }
    else{
        $error = 'Le token a ete envoyé'; // pour masquer le fait que le mail n existe pas
    }

}





?>
<div class="container">

    <?= $error; ?>
    <form action="" method="POST">
        <label for="">entrez votre email</label>
        <input type="email" name="email" id="">

        
        <button class="btn btn-primary">Envoyer</button>
    </form>
</div>


<?php
require 'views/partials/footer.php';