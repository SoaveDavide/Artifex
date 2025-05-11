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
                        <a href="../carrello/cart.php" class="btn btn-dark">Aggiungi al carrello</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require '../footer/footer.php'; ?>
