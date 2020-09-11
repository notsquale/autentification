<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?=$baseUrl;?>">Autentification</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?=$baseUrl; ?>/login.php">Connection</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?=$baseUrl; ?>/register.php">Inscription</a>
                    </li>

                    <?php if($user = isLogged()) { ?>

                        <li>
                            <span class='nav-link'> <?= $user['pseudo']?></span>
                           
                        </li>
                  <?php  } ?>
                   
                </ul>
            </div>
        </nav>