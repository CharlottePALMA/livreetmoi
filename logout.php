<?php

require 'inc/intro.php';


unset($_SESSION['user']);
unset($_SESSION['prenom']);
unset($_SESSION['email']);

header("Location: /index.php?a=".time(NULL));
?>