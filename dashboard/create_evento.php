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
// Query per ottenere nome e cognome delle guide
$query = "SELECT nome, cognome FROM guide";
$stmt_guide = $db->query($query);
$guide = $stmt_guide->fetchAll();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_evento = $_POST['name'];
    $minimo = $_POST['minimo'];
    $massimo = $_POST['massimo'];
    $prezzo = $_POST['prezzo'];
    $lingua = $_POST['lingua'];
    $nome_guida = $_POST['nome_guida'];
    $cognome_guida = $_POST['cognome_guida'];

    $query = "INSERT INTO eventi (nome, n_minimo, n_massimo, prezzo, nome_lingua, nome_guida, cognome_guida) 
              VALUES (:nome, :minimo, :massimo, :prezzo, :lingua, :nome_guida, :cognome_guida)";
    $stm = $db->prepare($query);
    $stm->bindValue(':nome', $nome_evento);
    $stm->bindValue(':minimo', $minimo);
    $stm->bindValue(':massimo', $massimo);
    $stm->bindValue(':prezzo', $prezzo);
    $stm->bindValue(':lingua', $lingua);
    $stm->bindValue(':nome_guida', $nome_guida);
    $stm->bindValue(':cognome_guida', $cognome_guida);
    $stm->execute();

    echo "<div class='container'><p style='color: green;'>Evento inserito con successo!</p></div>";
}

?>
    <div class="container">
        <h1>Inserimento di una guida</h1>
        <form action="create_evento.php" method="post">
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
            <label for="nome_guida">Seleziona il nome della guida</label>
            <select name="nome_guida" id="nome_guida" required>
                <?php foreach ($guide as $guida): ?>
                    <option value="<?= htmlspecialchars($guida['nome'])  ?>">
                        <?= htmlspecialchars($guida['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="cognome_guida">Seleziona il cognome della guida</label>
            <select name="cognome_guida" id="cognome_guida" required>
                <?php foreach ($guide as $guida): ?>
                    <option value="<?= htmlspecialchars($guida['cognome'])  ?>">
                        <?= htmlspecialchars($guida['cognome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <input type="submit" value="Invia dati">
        </form>
    </div>
<?php
require '../footer/footer.php';
