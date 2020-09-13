
<?php

require 'config/config.php';

require 'views/partials/header.php';

require 'views/partials/footer.php';




/* 

4 pages:

inscription
connection
mot de passe oublie
formulaire de chargement de mdp

1 table user:
id
email
password
pseudo

1 table token
user_id
token
token_validity

 */
//var_dump($_SESSION);
