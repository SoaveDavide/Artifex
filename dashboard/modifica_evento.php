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
    $n_minimo = $_POST['minimo'];
    $n_massimo = $_POST['massimo'];
    $prezzo = $_POST['prezzo'];
    $lingua = $_POST['lingua'];

    $query = "UPDATE eventi 
              SET n_minimo = :n_minimo, 
                  n_massimo = :n_massimo, 
                  prezzo = :prezzo, 
                  nome_lingua = :nome_lingua 
              WHERE nome = :nome_evento";
    $stm = $db->prepare($query);
    $stm->bindValue(':nome_evento', $nome);
    $stm->bindValue(':n_minimo', $n_minimo);
    $stm->bindValue(':n_massimo', $n_massimo);
    $stm->bindValue(':prezzo', $prezzo);
    $stm->bindValue(':nome_lingua', $lingua);
    $stm->execute();

    echo "<div class='container'><p style='color: green;'>Evento aggiornato con successo!</p></div>";
}

?>
    <div class="container">
        <h1>Aggiornamento dati di un evento</h1>
        <form action="modifica_evento.php" method="post">
            <label for = "name">Inserisci il nome dell'evento</label>
            <input type="text" name="name" id = "name" required>
            <label for = "minimo">Inserisci il numero minimo di persone</label>
            <input type="number" name="minimo" id = "minimo">
            <label for = "massimo">Inserisci il numero massimo di persone</label>
            <input type="number" name = "massimo" id = "massimo">
            <label for = "prezzo">Inserisci il prezzo</label>
            <input name="prezzo" type="number" id = "prezzo">
            <label for="lingua">Inserisci la lingua dell'evento</label>
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
