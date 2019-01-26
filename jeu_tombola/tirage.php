<?php
session_start();

$ticketDeTombola = range(1,100);
$winningTicket = generateWin($ticketDeTombola);
$ticketIHave = $_SESSION['tombola']['boughttickets'];
$myWallet = $_SESSION['tombola']['money'];

/**
 *  Fonction qui enregistre 3 valeurs de numéro pour définir les numéro gagnants
 *
 * @param array $tableau
 * @return $winningTickets qui est un tableau composé de 3 éléments, les 3 numéros gagnants
 */
function generateWin($tableau){
    shuffle($tableau);
    for($i = 1; $i <= 3 ; $i++){
            // $boughtTicket = [];
            $winningTickets[$i] = array_pop($tableau) ;
    }
    return $winningTickets;
}

// var_dump($winningTicket);
// var_dump($_SESSION['tombola']['boughttickets']);

/**
 * Fonction qui compare mon tableau des tickets gagnants avec le tableau des tickets achetés. Si un des premiers se retrouve dans le second alors il se stock dans un tableau appelé $result et qui est retourné.
 *
 * @param array $winnerTicket
 * @param array $boughtTicket
 * @return array  $result // les tickets achetés qui sont gagnants 
 */
function compareTicket($winnerTicket, $boughtTicket){
    $result = array_intersect($winnerTicket, $boughtTicket);
    return $result;
}
// $result = array_diff($winningTicket, $_SESSION['tombola']['boughttickets']);
$result = compareTicket($winningTicket, $ticketIHave);
// var_dump($result);
// echo $winningTicket[1];
// echo $winningTicket[2];
// echo $winningTicket[3];
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Le tirage du jour </h1>
  <h2>Les tickets gagnant sont :</h2>
<form action="index.php">
<!-- <form action=""> -->

<?php
    foreach($winningTicket as $key => $value) : 
?>
    <p><?= 'Prix n° ' .($key). ' est le numéro ' .$value ?></p>
<?php
    endforeach;

PHP_EOL;

//*****************************//Permet d'afficher si on a acheté des tickets gagnants (ne s'affiche que si on gagne)//*********************************** */
for($i=1; $i <= $_SESSION['tombola']['ticketwanted']; $i++){

    if(isset($result[$i])){
        if($result[$i] == $winningTicket[1] ){
            echo 'Vous avez gagné le 1er prix, soit 100€. Bravo !';
            $myWallet += 100;
        }elseif($result[$i] == $winningTicket[2]){
            echo 'Vous avez gagné le 2eme prix, soit 50€. Bravo !';
            $myWallet += 50;
        }elseif($result[$i] == $winningTicket[3]){
            echo 'Vous avez gagné le 3eme prix, soit 20€. Bravo !';
            $myWallet += 20;
        }else{
            echo 'Vous n\'avez pas gagné, vous pouvez retenter votre chance !';
        }
    }
}
?>
<br><br>
<br><br>
<h2>Voici vos tickets déjà achetés : </h2>

<div class="form-group">
<?php

    foreach($_SESSION['tombola']['boughttickets'] as $key => $value){
      echo 'Ticket n°'. ($key).' : '.$value .' <br>';
    }
?>
</div>
<div class="form-group">
    <label for="moneyleft">Votre solde restant : </label>
    <!-- <input type="text" readonly class="form-control-plaintext" id="moneyleft" value="Mes sous qui restent">  -->
    <p> <?= $myWallet   ;?> € </p>
</div>
<div class="form-group">
    <label for="tirage">Voulez-vous acheter des tickets pour un nouveau un tirage ?</label>
  <button type="submit" class="btn btn-primary" id="tirage" name='tirage'>Oui !</button>
</div>

<?php 
// pour garder le nouveau solde si on revient sur la première page. mais ça ne marche pas
if(isset($_POST['tirage'])){

    $_SESSION['tombola']['money'] = $myWallet;
    $page = '.';
    header('Location:' . $page);
    exit();
}
?>
</form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>