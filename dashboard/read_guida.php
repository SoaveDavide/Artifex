<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';

$db = artifex\Db_connection::getDB($config);


$query = "SELECT * FROM guide";

$stmt = $db->prepare($query);
$stmt->execute();

// Output della dashboard
echo '<table class="table-styled"> ';
echo '<thead>';
echo '<tr>';
echo '<th>Nome</th>';
echo '<th>Cognome</th>';
echo '<th>Titolo di studio</th>';
echo '<th>Luogo di nascita</th>';
echo '<th>Data di nascita</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

while ($row = $stmt->fetch()) {
    echo '<tr>';
    echo '<td>' . $row['nome'] . '</td>';
    echo '<td>' . $row['cognome'] . '</td>';
    echo '<td>' . $row['titolo_studio'] . '</td>';
    echo '<td>' . $row['luogo_nascita'] . '</td>';
    echo '<td>' . $row['data_nascita'] . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

$stmt->closeCursor();


?>
<?php
require '../footer/footer.php';
