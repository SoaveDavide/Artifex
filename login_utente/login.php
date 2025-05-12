<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "../vendor/autoload.php";
require_once '../header/header.php';
require_once '../DbConnection.php';

function Sendemail($destinatario){
    $body = "Benvenuto nel nostro sito! Grazie per esserti registrato!";
    $mail = new PHPMailer(true);

    try {

        // Configurazione del server SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Mittente e destinatario
        $mail->setFrom('davide.soave@iisviolamarchesini.edu.it');
        $mail->addAddress($destinatario);

        // Contenuto dell'email
        $mail->Subject = 'Informazioni sul servizio';
        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // Invio dell'email
        $mail->send();
        echo 'Email inviata con successo!';
    } catch (Exception $e) {
        echo "Errore nell'invio dell'email: {$mail->ErrorInfo}";
    }
}
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
    Sendemail($email);
    $_SESSION['username'] = $nome;
    $_SESSION['email'] = $email;
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
