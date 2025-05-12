<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';

$db = artifex\Db_connection::getDB($config);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT password, email FROM amministratore WHERE email = :email";
    $stm = $db->prepare($query);
    $stm->bindValue(':email', $email);
    $stm->execute();
    $user = $stm->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username_amministratore'] = $user['email'];
        header("Location: ../home/home.php");
        exit();
    } else {
        $errorMessage = "Email o password errati.";
    }
}

?>
<div class="container">
    <h1>Accedi</h1>
    <form action="login_amministratore.php" method="post">
        <label for="email">Inserisci email:</label>
        <input type="text" name="email" id="email" required>
        <label for="password">Inserisci la password:</label>
        <input id="password" name="password" type="password" required>
        <input type="submit" value="Accedi">
    </form>
    <?php if (isset($errorMessage)): ?>
        <p style="color: red; text-align: center;"><?= ($errorMessage) ?></p>
    <?php endif; ?>
</div>
<?php
require_once '../footer/footer.php';
?>
