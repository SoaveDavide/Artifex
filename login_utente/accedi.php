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

    $query = "SELECT password, nome FROM visitatori WHERE email = :email";
    $stm = $db->prepare($query);
    $stm->bindValue(':email', $email);
    $stm->execute();
    $user = $stm->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['nome'];
        $_SESSION['email'] = $email;
        header("Location: ../home/home.php");
        exit();
    } else {
        $errorMessage = "Email o password errati.";
    }
}

?>
<div class="container">
    <h1>Accedi</h1>
    <form action="accedi.php" method="post">
        <label for="email">Inserisci email:</label>
        <input type="text" name="email" id="email" required>
        <label for="password">Inserisci la password:</label>
        <input id="password" name="password" type="password" required>
        <input type="submit" value="Accedi">
        <p style="text-align: center; margin-top: 15px;">
            Non hai un account? <a href="login.php" style="color: #d19b06; font-weight: bold;">Registrati qui</a>
        </p>
    </form>
    <?php if (isset($errorMessage)): ?>
        <p style="color: red; text-align: center;"><?= ($errorMessage) ?></p>
    <?php endif; ?>
</div>
<?php
require_once '../footer/footer.php';
?>
