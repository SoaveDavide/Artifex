<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';

$db = artifex\Db_connection::getDB($config);

// Prendi tutte le lingue dal database
$query_lingue = "SELECT nome FROM lingue";
$stmt_lingue = $db->query($query_lingue);
$lingue = $stmt_lingue->fetchAll();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['name'];
    $cognome = $_POST['cognome'];
    $titolo_studio = $_POST['titolo'];

    $query = "UPDATE guide SET titolo_studio = :titolo_studio WHERE nome = :nome AND cognome = :cognome";
    $stm = $db->prepare($query);
    $stm->bindValue(':nome', $nome);
    $stm->bindValue(':cognome', $cognome);
    $stm->bindValue(':titolo_studio', $titolo_studio);
    $stm->execute();

}
?>
    <div class="container">
        <h1>Aggiornamento dati di una guida</h1>
        <form action="update_guida.php" method="post">
            <label for = "name">Inserisci il nome della guida</label>
            <input type="text" name="name" id = "name" required>
            <label for = "cognome">Inserisci il cognome della guida</label>
            <input type="text" name="cognome" id = "cognome" required>
            <label for = "titolo">Inserisci il titolo di studio della guida</label>
            <input type="text" name="titolo" id = "titolo" required>
            <input type="submit" value="Invia dati">
        </form>
    </div>
<?php
require '../footer/footer.php';
