

<?php 
//on défini la fonction qui récupère les datas et les transforme en json
function getData(){

// on crée le tableau qui contiendra nos valeurs    
$display = array();

//on récupère le paramètre envoyé par le client
$lastnombre = htmlspecialchars($_GET["lastnombre"]);

//echo $valeurtest;
//$valeurtest = valeurtest;

//on initialise la connection avec la DB
include("db.php");

//on défini la procédure selon l'affichage désiré et on stock dans $stmt :

//ici pour toutes les entrées
if($lastnombre == "all"){
    $stmt = $dbh->prepare("SELECT * from entries order by id_entry DESC");
}

//ici pour le mois (31jours * 24 entrées = 744)
if($lastnombre == "month"){
    $stmt = $dbh->prepare("SELECT * from entries order by id_entry DESC limit 744");
}

//ici par semaine (7j * 24entrées = 168)
if($lastnombre == "week"){
    $stmt = $dbh->prepare("SELECT * from entries order by id_entry DESC limit 168");
}

//ici pour les affichages personalisés
if(is_numeric($lastnombre)){
    $stmt = $dbh->prepare("SELECT * from entries order by id_entry DESC limit $lastnombre");
}

//on execute la procédure stockée
$stmt->execute();
while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
    //print $data['id_entry'] . $data['temperature'] . $data['humidite'];
    //print_r($data);

    // on ajoute le résultat de la procédure dans un tableau
    array_push($display,$data);  
}

//on encode le tableau vers un json
echo json_encode($display, JSON_NUMERIC_CHECK);
return;
}

//on affiche le json pour le graphique
echo getData();
//echo $valeurtest;
?>

