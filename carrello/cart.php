<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';

$db = artifex\Db_connection::getDB($config);

// Simulazione utente loggato (se non esiste, diventa guest)
$email = $_SESSION['username'];
$stm = $db->prepare("SELECT email FROM visitatori WHERE email = :email");
$stm->bindValue(':email', $email);
$stm->execute();
if (!$stm->fetch()) {
    $username = 'guest';
}

// Gestione delle azioni POST (rimozione o checkout)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Rimozione di un singolo prodotto dal carrello
    if (isset($_POST['remove'])) {
        $nome_evento = $_POST['remove'];

        // Recupera l'id del carrello attivo per l'utente
        $stm = $db->prepare("SELECT data_creazione FROM carrelli WHERE DATE(data_creazione) = CURDATE() AND email_utente = :email");
        $stm->bindValue(':email', $email);
        $stm->execute();
        $carrello = $stm->fetch();

        if ($carrello) {
            // Rimuovi l'evento dal carrello
            $stm = $db->prepare("DELETE FROM contenere WHERE email_utente = :email AND data_creazione = :data_creazione AND nome_evento = :nome_evento");
            $stm->execute([
                'email' => $email,
                'data_creazione' => $carrello->data_creazione,
                'nome_evento' => $nome_evento
            ]);

            $message = "Evento rimosso dal carrello.";
        }
    }

    // Gestione del checkout: svuota il carrello
    if (isset($_POST['checkout'])) {
        $stm = $db->prepare("SELECT data_creazione FROM carrelli WHERE DATE(data_creazione) = CURDATE() AND email_utente = :email");
        $stm->bindValue(':email', $email);
        $stm->execute();
        $carrello = $stm->fetch();

        if ($carrello) {
            // Elimina gli eventi aggiunti al carrello
            $stm = $db->prepare("DELETE FROM contenere WHERE email_utente = :email AND data_creazione = :data_creazione");
            $stm->execute([
                'email' => $email,
                'data_creazione' => $carrello->data_creazione
            ]);

            // Elimina il carrello stesso
            $stm = $db->prepare("DELETE FROM carrelli WHERE data_creazione = :data_creazione AND email_utente = :email");
            $stm->execute([
                'data_creazione' => $carrello->data_creazione,
                'email' => $email
            ]);

            $message = "Checkout completato. Il tuo ordine è stato processato e il carrello è stato svuotato.";
        } else {
            $message = "Nessun carrello attivo trovato.";
        }
    }
}

// Recupera il carrello attivo per l'utente
$stm = $db->prepare("SELECT data_creazione FROM carrelli WHERE DATE(data_creazione) = CURDATE() AND email_utente = :email");
$stm->bindValue(':email', $email);
$stm->execute();
$carrello = $stm->fetch();

// Se non c'è un carrello, mostra messaggio e interrompi l'esecuzione
if (!$carrello) {
    echo "<div class='container mt-5 alert alert-warning text-center'>Il tuo carrello è vuoto.</div>";
    require "../footer/footer.php";
    exit();
}

// Recupera tutti gli eventi nel carrello dell'utente
$stm = $db->prepare("
    SELECT e.nome, c.data_creazione, e.prezzo
    FROM contenere c
    JOIN eventi e ON c.nome_evento = e.nome
    WHERE c.email_utente = :email AND c.data_creazione = :data_creazione
");
$stm->execute([
    'email' => $email,
    'data_creazione' => $carrello->data_creazione
]);
$eventi = $stm->fetchAll();

// Calcolo totale del carrello
$total = 0;
foreach ($eventi as $evento) {
    $total += $evento->prezzo;
}

?>

<!-- HTML per visualizzare il contenuto del carrello -->
<div class="container mt-5">
    <h1 class="text-center mb-4">Il tuo Carrello</h1>

    <!-- Messaggio informativo se presente -->
    <?php if (isset($message)): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Verifica se il carrello è vuoto -->
    <?php if (empty($eventi)): ?>
        <div class="alert alert-warning text-center">Il tuo carrello è vuoto.</div>
    <?php else: ?>
        <!-- Elenco degli eventi -->
        <?php foreach ($eventi as $evento): ?>
            <div class="row mb-3 align-items-center">
                <div class="col-md-8">
                    <h5><?= htmlspecialchars($evento->nome) ?></h5>
                    <p>Prezzo: €<?= number_format($evento->prezzo, 2, ',', '.') ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <!-- Form per rimuovere un evento dal carrello -->
                    <form method="POST">
                        <input type="hidden" name="remove" value="<?= htmlspecialchars($evento->nome) ?>" />
                        <button type="submit" class="btn btn-danger btn-sm">Rimuovi</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Totale generale del carrello -->
        <h3 class="text-end">Totale Carrello: €<?= number_format($total, 2, ',', '.') ?></h3>

        <!-- Pulsante per il checkout -->
        <div class="text-end">
            <form method="POST">
                <button type="submit" name="checkout" class="btn btn-success mt-3">Procedi al Checkout</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require "../footer/footer.php"; ?>
