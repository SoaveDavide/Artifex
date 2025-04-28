<?php
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';
$db = artifex\Db_connection::getDB($config);

// Prendi tutte le lingue dal database
$query_lingue = "SELECT nome FROM lingue";
$stmt_lingue = $db->query($query_lingue);
$lingue = $stmt_lingue->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_cripted = password_hash($password, PASSWORD_DEFAULT);
    $numero_telefono = $_POST['numero_telefono'];
    $nome = $_POST['nome'];
    $nazionalita = $_POST['nazionalita'];
    $lingua = $_POST['lingua'];

    $query = "INSERT INTO visitatori(email, password, numero_telefono, nome, nazionalita, lingua_base) 
              VALUES (:email, :password, :numero_telefono, :nome, :nazionalita, :lingua_base)";
    $stm = $db->prepare($query);
    $stm->bindValue(':email', $email);
    $stm->bindValue(':password', $password_cripted);
    $stm->bindValue(':numero_telefono', $numero_telefono);
    $stm->bindValue(':nome', $nome);
    $stm->bindValue(':nazionalita', $nazionalita);
    $stm->bindValue(':lingua_base', $lingua);
    $stm->execute();
}
?>

<div class="container">
    <h1>Registrazione utente</h1>
    <form action="" method="post">
        <label for="email">Inserisci email:</label>
        <input type="text" name="email" id="email" required>

        <label for="password">Inserisci la password:</label>
        <input id="password" name="password" type="password" required>

        <label for="numero_telefono">Inserisci numero di telefono:</label>
        <input type="text" name="numero_telefono" id="numero_telefono" required>

        <label for="nome">Inserisci il tuo nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="nazionalita">Inserisci la tua nazionalità:</label>
        <input type="text" name="nazionalita" id="nazionalita" required>

        <label for="lingua">Seleziona la tua lingua:</label>
        <select name="lingua" id="lingua" required>
            <?php foreach ($lingue as $lingua) : ?>
                <option value="<?= ($lingua['nome']) ?>">
                    <?= ($lingua['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" value="Invia registrazione">

        <p style="text-align: center; margin-top: 15px;">
            Hai già un account? <a href="accedi.php" style="color: #d19b06; font-weight: bold;">Accedi qui</a>
        </p>
    </form>
</div>

<?php
require_once '../footer/footer.php';
?>
