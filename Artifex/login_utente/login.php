<?php
require '../header/header.php';
require_once  '../header/header.php';
require_once '../DbConnection.php';

$config = require  '../DBconfig.php';

$db = artifex\Db_connection::getDB($config);
?>
<div class="container">
    <h1>Registrazione utente</h1>
    <form action="login.php" method="post">
        <label for = "email">Inserisci email:</label>
        <input type="text" name="email" id = "email" required>
        <label for = "password">Insersci la password:</label>
        <input id = "password" name = "password" type="password" required>
        <label for = "numero_telefono">Inserisci numero di telefono:</label>
        <input type="text" name="numero_telefono" id = "numero_telefono" required>
        <label for = "nome">Inserisci il tuo nome</label>
        <input type="text" required name="nome" id = "nome">
        <label for = "nazionalita">Inserisci la tua nazionalità</label>
        <input type="text" required name="nazionalita" id = "nazionalita">
        <input type="submit" value="Invia registrazione">
        <p style="text-align: center; margin-top: 15px;">
            Hai già un account? <a href="accedi.php" style="color: #d19b06; font-weight: bold;">Accedi qui</a>
        </p>
    </form>
</div>
<?php
require '../footer/footer.php';