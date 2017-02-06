<?php
require_once('class.php');



// Récupération des données

    $prix_poids = 0;
    $distance_poids = 0;
    $nbet_poids = 0;
    $prix_pref = 0;
    $distance_pref = 0;
    $nbet_pref =0;

// Conversion
    $prix_poids_float = 0;
    $distance_poids_float = 0;
    $nbet_poids_float = 0;



recuperation();

function recuperation(){

global $prix_poids_float, $distance_poids_float, $nbet_poids_float;

// Récupération des données

	$prix_poids = (float)$_GET['prix_poids'];
	$distance_poids = (float)$_GET['distance_poids'];
	$nbet_poids = (float)$_GET['nbet_poids'];
	$prix_pref = $_GET['prix_pref'];
	$distance_pref = $_GET['distance_pref'];
	$nbet_pref = $_GET['nbet_pref'];

// Conversion
	$prix_poids_float = $prix_poids/100 ;
	$distance_poids_float = $distance_poids/100;
	$nbet_poids_float = $nbet_poids/100;

// Vérification poids = 100

		if( $prix_poids_float + $distance_poids_float + $nbet_poids_float == 1){
			
			connexion($prix_poids, $distance_poids, $nbet_poids, $prix_pref, $distance_pref, $nbet_pref);
		}else{
			echo 'Erreur somme';
		}
		
}


function connexion($prix_poids, $distance_poids, $nbet_poids, $prix_pref, $distance_pref, $nbet_pref){
	// Connexion base de données
try
{
	$hotel= new Hotel();
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

    //$data=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $result=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
    }
    
    //var_dump($result);
    normalisation($result);

} catch (PDOException $e){
    echo 'Echec Skyline : ' . $e->getMessage();
}

}

// Minimum
        function minimum($tab, $attribut) {
            $min = $tab[0]["$attribut"];
            for($i = 0; $i < count($tab); ++$i) {
                if($tab[$i]["$attribut"] < $min) {
                    $min = $tab[$i]["$attribut"];
                }
            }
            return $min;
        }

// Maximum
        function maximum($tab, $attribut) {
            $max = $tab[0]["$attribut"];
            for($i = 0; $i < count($tab); ++$i) {
                if($tab[$i]["$attribut"] > $max) {
                    $max = $tab[$i]["$attribut"];
                }
            }
            return $max;
        }


// Normalisation des critères :
function normalisation($data){
    $result_norm=array();
    //var_dump($data);
    for($i = 0; $i<count($data); ++$i)
    {
            $result_norm[$i]["IdH"] = $data[$i]["IdH"];
            $result_norm[$i]["Prix"] = round(floatval(($prix_pref == 'min') ? minimum($data, "Prix")/$data[$i]["Prix"] : $data[$i]["Prix"]/maximum($data, "Prix")),3);
            $result_norm[$i]["Distance"] = round(floatval(($distance_pref == 'min') ? minimum($data, "Distance")/$data[$i]["Distance"] : $data[$i]["Distance"]/maximum($data, "Distance")),3);
            $result_norm[$i]["NbEt"] = round(floatval(($nbet_pref == 'min') ? minimum($data, "NbEt")/$data[$i]["NbEt"] : $data[$i]["NbEt"]/maximum($data, "NbEt")),3);
    }


	//var_dump( $result_norm);
    ponderation($result_norm);

}

function ponderation($data){
    $result_pond = array();

    global $prix_poids_float, $distance_poids_float, $nbet_poids_float;

    //var_dump($data);
   // echo($data[0]["Prix"]);
    
    for($i = 0; $i < count($data); ++$i){
        $result_pond[$i]["IdH"] = $data[$i]["IdH"];
        $result_pond[$i]["Prix"] = round($prix_poids_float*$data[$i]["Prix"],3);
        $result_pond[$i]["Distance"] = round($distance_poids_float*$data[$i]["Distance"],2);
        $result_pond[$i]["NbEt"] = round($nbet_poids_float*$data[$i]["NbEt"],2);
        
    }
    score($result_pond);
}

function score($data){
    $result_score=array();
    for($i = 0; $i < count($data); ++$i)
    {
        $result_score[$i]["score"] = round($data[$i]["Prix"]+$data[$i]["Distance"]+$data[$i]["NbEt"],2);
    }
    //var_dump($result_score);


    $dbh = null;

    $score = array();

    foreach ($data as $key => $row) {
        //var_dump($key);
        $score[$key] = $row['score'];
    }

    //var_dump($score);

    array_multisort($score, SORT_DESC, $data);
        //var_dump($result_pond);

        echo json_encode($data);
}








//$dbh = null;



?>
