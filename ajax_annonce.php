
<?php
require_once('../assets/config/init.php');
?>
<?php

$tab = array(); //on stock nos echos

$result= $bdd->query("SELECT * FROM annonce WHERE categorie_id = '$_POST[id]'");

$tab['resultat'] = '<table class="table-fluid table-bordered text-center mt-4"><tr>' ;
for($i=0; $i<$result->columnCount(); $i++){

  $colonne = $result->getColumnMeta($i);
// echo '<pre>; print_r($colonne); echo '</pre>';

  $tab['resultat'] .= "<th>$colonne[name]</th>";

}
$tab['resultat'] .= '</tr>';

while($annonce = $result->fetch(PDO::FETCH_ASSOC))
{
    $tab['resultat'] .= '<tr>';

    foreach($annonce as $value)
    {
        $tab['resultat'] .= "<td>$value</td>";
    }
    $tab['resultat'] .= '</tr>';
}

$tab['resultat'] .= '</table>';

echo json_encode($tab);
?>
