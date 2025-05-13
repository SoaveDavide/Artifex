<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';
$db = artifex\Db_connection::getDB($config);

$query = "SELECT * FROM eventi";
$stm = $db->prepare($query);
$stm->execute();
$eventi = $stm->fetchAll(PDO::FETCH_ASSOC);

//Utente loggato
$email = $_SESSION['email'];
$stm = $db->prepare("SELECT email FROM visitatori WHERE email = :email");
$stm->bindValue(':email', $email);
$stm->execute();

// Gestione dell'invio del form POST (aggiunta al carrello)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['evento_nome'])) {
    $nome_prodotto = $_POST['evento_nome'];  // Get the event name from the form

    // Verifica se esiste già un carrello per l'utente nella data odierna
    $query_carrello = "SELECT data_creazione FROM carrelli WHERE DATE(data_creazione) = CURDATE() AND email_utente = :email";
    $stm = $db->prepare($query_carrello);
    $stm->bindValue(':email', $email, PDO::PARAM_STR);
    $stm->execute();
    $carrello = $stm->fetch(PDO::FETCH_OBJ);

// Se il carrello non esiste, creane uno
    if (!$carrello) {
        $query_crea = "INSERT INTO carrelli (data_creazione, email_utente) VALUES (NOW(), :email)";
        $stm = $db->prepare($query_crea);
        $stm->bindValue(':email', $email);
        $stm->execute();
        $carrello_data = date('Y-m-d H:i:s'); // NOW() nel formato PHP
    } else {
        $carrello_data = $carrello->data_creazione;
    }

// Controlla se l'evento è già presente nel carrello dell'utente
    $query_check = "SELECT * FROM contenere WHERE email_utente = :username AND nome_evento = :nome_prodotto AND data_creazione = :data_creazione";
    $stm = $db->prepare($query_check);
    $stm->bindValue(':username', $email);
    $stm->bindValue(':nome_prodotto', $nome_prodotto);
    $stm->bindValue(':data_creazione', $carrello_data);
    $stm->execute();
    $existing = $stm->fetch();

// Se già presente, messaggio
    if ($existing) {
        echo "<div class='container mt-5 alert alert-success text-center fw-bold'>Evento già nel carrello!</div>";
    } else {
        $query_insert = "INSERT INTO contenere (nome_evento, data_creazione, email_utente) VALUES (:nome_prodotto, :data_creazione, :username)";
        $stm = $db->prepare($query_insert);
        $stm->bindValue(':nome_prodotto', $nome_prodotto);
        $stm->bindValue(':data_creazione', $carrello_data);
        $stm->bindValue(':username', $email);
        $stm->execute();

        echo "<div class='container mt-5 alert alert-success text-center fw-bold'>Evento aggiunto al carrello!</div>";
    }

}
?>
<div class="bg-body-tertiary text-center p-5 rounded-3">
    <h1 class="text-danger"><strong>ARTIFEX</strong></h1>
    <p class="lead">Trova tutti i migliori eventi al giusto prezzo per te e la tua famiglia.</p>

    <h2 class="mt-5">Tutti gli eventi</h2>
    <div class="row mt-3">
        <?php foreach ($eventi as $evento) : ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm products">
                    <div class="card-body">
                        <h5 class="card-title">Evento: <?= htmlspecialchars($evento['nome']) ?></h5>
                        <p><strong>Lingua:</strong> <?= htmlspecialchars($evento['nome_lingua']) ?></p>
                        <p><strong>Guida:</strong> <?= htmlspecialchars($evento['nome_guida']) . ' ' . htmlspecialchars($evento['cognome_guida']) ?></p>
                        <p><strong>Prezzo:</strong> €<?= number_format($evento['prezzo'], 2) ?></p>
                        <p><strong>Partecipanti:</strong> min <?= $evento['n_minimo'] ?> - max <?= $evento['n_massimo'] ?></p>

                        <!-- Form for adding the event to the cart -->
                        <form action="" method="POST">
                            <input type="hidden" name="evento_nome" value="<?= htmlspecialchars($evento['nome']) ?>" />
                            <button type="submit" class="btn btn-dark">Aggiungi al carrello</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require '../footer/footer.php'; ?>
