<?php

require_once('class.php');
$hotel= new Hotel();

$prix_poids = $_GET['prix_poids'];
$distance_poids = $_GET['distance_poids'];
$nbet_poids = $_GET['nbet_poids'];
$prix_pref = $_GET['prix_pref'];
$distance_pref = $_GET['distance_pref'];
$nbet_pref = $_GET['nbet_pref'];






// Connexion base de données
try
{
    $dbh = new PDO($hotel->getHost(),$hotel->getUser(),$hotel->getPass());
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo 'Echec lors de la connexion : ' . $e->getMessage();
}

// Drop view

try
{
    $stmt=$dbh->prepare("DROP VIEW IF EXISTS Hotel_Sky");
    $stmt->execute();

} catch (PDOException $e){
    echo 'Echec : ' . $e->getMessage();
}

try
{
    $stmt=$dbh->prepare("DROP VIEW IF EXISTS Hotel_Norm");
    $stmt->execute();

} catch (PDOException $e){
    echo 'Echec : ' . $e->getMessage();
}

try
{
    $stmt=$dbh->prepare("DROP VIEW IF EXISTS Hotel_Pond");
    $stmt->execute();

} catch (PDOException $e){
    echo 'Echec : ' . $e->getMessage();
}

try
{
    $stmt=$dbh->prepare("DROP VIEW IF EXISTS Hotel_Score");
    $stmt->execute();

} catch (PDOException $e){
    echo 'Echec : ' . $e->getMessage();
}

if($prix_pref == 'MIN')
{
    $inequation_prix[0] = '<=';
    $inequation_prix[1] = '<';


    //echo $inequation_prix[0];
} else
{
    $inequation_prix[0] = '>=';
    $inequation_prix[1] = '>';
}

if($distance_pref == 'MIN')
{
    $inequation_distance[0] = '<=';
    $inequation_distance[1] = '<';
} else
{
    $inequation_distance[0] = '>=';
    $inequation_distance[1] = '>';
}

if($nbet_pref == 'MIN')
{
    $inequation_nbet[0] = '<=';
    $inequation_nbet[1] = '<';

} else
{
    $inequation_nbet[0] = '>=';
    $inequation_nbet[1] = '>';
}

// Requete Hotel_Sky

try
{
    $stmt=$dbh->prepare('CREATE VIEW Hotel_Sky AS SELECT IdH, Prix, Distance, NbEt
    FROM HOTEL H1 
    WHERE NOT EXISTS (SELECT * 
    FROM HOTEL H2 WHERE (H2.Prix ' . $inequation_prix[0] .' H1.Prix 
    AND H2.Distance '. $inequation_distance[0] .' H1.Distance 
    AND H2.NbEt '. $inequation_nbet[0] .' H1.NbEt ) 
    AND (H2.Prix '. $inequation_prix[1] .' H1.Prix
    OR H2.Distance '. $inequation_distance[1] .' H1.Distance
    OR H2.NbEt '. $inequation_nbet[1] .' H1.NbEt)
    );');

    $stmt->execute();

    $stmt=$dbh->prepare('SELECT * FROM Hotel_Sky');

    $stmt->execute();

    $data=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = json_encode($data);

    normalisation($data);

} catch (PDOException $e){
    echo 'Echec Skyline : ' . $e->getMessage();
}

function normalisation($data){


}



//$dbh = null;



?>
