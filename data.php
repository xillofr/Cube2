

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
try {
    $dbh = new PDO('mysql:host=192.168.1.26;dbname=cube2', 'root', 'root');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

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
    // on ajoute le résultat de la procédure dans un tableau pour chaque ligne du résultat de la requête
    array_push($display,$data);  
}

//on encode le tableau vers un json
echo json_encode($display, JSON_NUMERIC_CHECK);
return;
}

//on affiche le json pour le graphique
echo getData();

?>

