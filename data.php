

<?php 
function getData(){
$display = array();

try {
    $dbh = new PDO('mysql:host=192.168.1.26;dbname=cube2', 'root', 'root');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$stmt = $dbh->prepare("SELECT * from entries order by id_entry DESC limit 15");

// appel de la procédure stockée
$stmt->execute();
while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
    //print $data['id_entry'] . $data['temperature'] . $data['humidite'];
    //print_r($data);
array_push($display,$data);  
}
//print "La procédure a retourné : $value\n";
   // print_r($display);
echo json_encode($display, JSON_NUMERIC_CHECK);
return;
}

echo getData();
?>

