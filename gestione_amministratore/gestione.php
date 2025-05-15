<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';

$db = artifex\Db_connection::getDB($config);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $password = $_POST['old_password'];
    $password_new = $_POST['new_password'];
    $email = $_SESSION['username_amministratore'];
    $query = "SELECT password FROM amministratore WHERE email = :email";
    $stm  = $db->prepare($query);
    $stm->bindValue(':email', $email);
    $stm->execute();
    $visitatore = $stm->fetch();
    if(password_verify($password, $visitatore['password'])){
        $query = "UPDATE amministratore SET password = :password WHERE email = :email";
        $stm  = $db->prepare($query);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':password', password_hash($password_new, PASSWORD_DEFAULT));
        $stm->execute();

        echo 'password changed';
    }else{
        echo 'password errata';
    }
}
?>
<div class="container">
    <h1>Gestione account, benvenuto <?php echo $_SESSION['username_amministratore'] ?>! </h1>
    <form action="gestione.php" method="post">
        <label for = "old_password">Inserisci la vecchia password:</label>
        <input id = "old_password" name = "old_password" type="password" required>
        <label for = "new_password">Inserisci la nuova password:</label>
        <input type="password" name="new_password" id = "new_password" required>
        <input type="submit" value="Inviare dati">
    </form>
    <br>
    <a href="../gestione_account/logout.php" class="btn btn-danger">Logout</a>

</div>
<?php
require '../footer/footer.php';
