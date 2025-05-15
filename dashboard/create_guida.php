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
    $data_nascita = $_POST['data_nascita'];
    $luogo_nascita = $_POST['luogo_nascita'];


    $query = "INSERT INTO guide(nome, cognome, titolo_studio, luogo_nascita,data_nascita) VALUES(:nome, :cognome, :titolo_studio, :data_nascita, :luogo_nascita)";
    $stm = $db->prepare($query);
    $stm->bindValue(':nome', $nome);
    $stm->bindValue(':cognome', $cognome);
    $stm->bindValue(':titolo_studio', $titolo_studio);
    $stm->bindValue(':luogo_nascita', $data_nascita);
    $stm->bindValue(':data_nascita', $luogo_nascita);
    $stm->execute();

}
?>
<div class="container">
    <h1>Inserimento di una guida</h1>
     <form action="create_guida.php" method="post">
         <label for = "name">Inserisci il nome della guida</label>
         <input type="text" name="name" id = "name" required>
         <label for = "cognome">Inserisci il cognome della guida</label>
         <input type="text" name="cognome" id = "cognome" required>
         <label for = "titolo">Inserisci il titolo di studio della guida</label>
         <input type="text" name="titolo" id = "titolo" required>
         <label for="data_nascita">Inserisci la data di nascita</label>
         <input type="date" name="data_nascita" id = "data_nascita" required>
         <label for="luogo_nascita">Inserisci il luogo di nascita</label>
         <input type="text" name="luogo_nascita" id = "luogo_nascita" required>
         <label for="lingua">Seleziona la tua lingua:</label>
         <select name="lingua" id="lingua" required>
             <?php foreach ($lingue as $lingua) : ?>
                 <option value="<?= ($lingua['nome']) ?>">
                     <?= ($lingua['nome']) ?>
                 </option>
             <?php endforeach; ?>
         </select>
         <br><br>
         <input type="submit" value="Invia dati">
     </form>
</div>
<?php
require '../footer/footer.php';
