<?php 
session_start();

$nombreDeTickets = range(1,100);

if(isset($_POST['ticketswanted'])){
$_SESSION['tombola']['ticketwanted'] = $_POST['ticketswanted'];
shuffle($nombreDeTickets);
}

/**
 * Fonction qui donne le nombre de ticket acheté
 *
 * @param [type] $numberwanted $_POST['ticketswanted']
 * @param array $tickets vaut le $nombreDeTickets
 * @return void
 */
// function buyTicket($numberwanted, $tickets){
// $bought = [''];
//     for($i = 0; $i <= $numberwanted;  $i ++){

//         $bought[] += $tickets[$i];
//     }
//     return $bought;
// }
// $achat = buyTicket($_SESSION['tombola']['ticketwanted'], $nombreDeTickets);
// // print_r($achat);
// var_dump($_POST['ticketswanted']);
// var_dump($achat);

/**
 * Fonction qui va donner le nombre de tickets que l'utilisateur veut acheter et va les sortir du tableau de ticket total
 *
 * @return void
 */
function buyTicket($ticketswanted, $nombreDeTickets){

     for($i = 1; $i  <= $ticketswanted; $i++){
            // $boughtTicket = [];
            $boughtTickets[$i] = array_pop($nombreDeTickets) ;
    }
    return $boughtTickets;
}

//****************************************************** */On va paramatrer le portefeuille du joueur

/***
 * fonction qui décompte le nombre de tickets acheté de notre cagnotte
 */
function myMoney($ticketIget, $myWallet){
    $myWallet = $myWallet - (2 * $ticketIget);
    return $myWallet;
}

$myWallet = 500;

if(isset($_POST['ticketswanted'])){
   $myWallet = myMoney($_POST['ticketswanted'],$myWallet)    ;
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Tombola</title>
  </head>
  <body>
    <h1>Bienvenue sur notre Tombola !</h1>
<br>
<br>
<form  action="" method="POST" class="form-inline">
  <div class="form-group mb-2">
    <!-- <label for="buyticket" class="sr-only">Combien de tickets voulez-vous acheter ?</label> -->
    <label for="buyticket">Combien de tickets voulez-vous acheter ? </label>
    <input type="text" class="form-control-plaintext" id="buyticket" >
  </div>
  <div class="form-group mx-sm-3 mb-2">
    <!-- <label for="ticketwanted" class="sr-only">Password</label> -->
    <input type="text" class="form-control" id="ticketwanted" placeholder="Nbre de tickets" name="ticketswanted">
  </div>
  <button type="submit" class="btn btn-primary mb-2">Validez votre achat</button>
</form>
<br>
<br>
<h2>Voici vos tickets déjà achetés : </h2>
<form action="">
  <div class="form-group">
<?php

    if(isset($_POST['ticketswanted'])){

        $ticketachete = buyTicket($_POST['ticketswanted'], $nombreDeTickets);  
        $_SESSION['tombola']['boughttickets'] = $ticketachete ;
        // var_dump($ticketachete);
        foreach($ticketachete as $key => $value){// affiche les tickets qu'on a acheté et leur valeur (le numéro unique)
        echo 'Ticket n°'. ($key).' : '.$value .' <br>';
        }
    }

    $_SESSION['tombola']['money'] = $myWallet;
?>
</div>
<br><br>
<div class="form-group">
    <label for="moneyleft">Votre solde restant : </label>
    <!-- <input type="text" readonly class="form-control-plaintext" id="moneyleft" value="<? $myWallet   ;?>€">  -->
    <p> <?= $myWallet   ;?> € </p>
</div>
</form>
<form 
<?= (isset($_POST['ticketswanted']) && intval($_POST['ticketswanted']) > 1 ) ? 'action="tirage.php"' : ' ';
?>
>
  <div class="form-group">
    <label for="tirage">Voulez-vous lancer un tirage ?</label>
  <button type="submit" class="btn btn-primary" id="tirage" name='tirage'>C'est parti !</button>
  </div>
</form>
<form>
  <div class="form-group">
    <label for="destroy">Voulez-vous recommencer toute la partie ?  (Attention vous perdrez vos parties déjà jouées)</label>
  <button type="submit" class="btn btn-primary" id="destroy" name="destroy">Oui :(</button>
  </div>
<?php
//***************************************************** */Permet de recommencer la partie à zéro.
if(isset($_POST['destroy'])){
    unset($_SESSION['tombola']);
    $page = $_SERVER['PHP_SELF'];
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