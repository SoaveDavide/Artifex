<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require '../header/header.php';
?>

<div class="container text-center my-5">
    <img src="../home_image.png" alt="Home Image" class="img-fluid" style="max-width: 60%; border-radius: 15px;">
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">I servizi che offriamo</h2>
    <div class="row justify-content-center g-4">

        <div class="col-md-4">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Registrazione e Login</h5>
                    <p class="card-text">Crea un account, ricevi una mail di benvenuto e accedi a tutte le funzionalità della piattaforma.</p>
                    <a href="../login_utente/login.php" class="btn btn-primary">Registrati</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Prenotazione Eventi</h5>
                    <p class="card-text">Prenota uno o più eventi con un solo pagamento, scegliendo liberamente tra diverse date e guide.</p>
                    <a href="../eventi_lista/event_lista.php" class="btn btn-primary">Prenota ora</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Carrello Prenotazioni</h5>
                    <p class="card-text">Consulta facilmente il tuo carrello con tutte le prenotazioni future selezionate prima dell'acquisto.</p>
                    <a href="../carrello/cart.php" class="btn btn-primary">Vai al carrello</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Area Personale</h5>
                    <p class="card-text">Visualizza il tuo profilo, gestisci le prenotazioni effettuate e cambia la tua password quando vuoi.</p>
                    <a href="../gestione_account/gestione.php" class="btn btn-primary">Profilo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Dashboard Admin</h5>
                    <p class="card-text">Gestisci eventi, date e guide da un'unica dashboard riservata agli amministratori del sistema.</p>
                    <?php if(isset($_SESSION['username_amministratore'])){?>
                    <a href="../dashboard/scelta_modifica.php" class="btn btn-primary">Dashboard</a>
                    <?php } else{ ?>
                    <a href = "../Login_amministratore/login_amministratore.php" class="btn btn-primary">Non sei loggato</a>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Biglietti e QR Code</h5>
                    <p class="card-text">Stampa i tuoi biglietti in PDF con QR code integrato, contenente tutti i dati dell'evento prenotato.</p>
                    <a href="../biglietti.php" class="btn btn-primary">Stampa Biglietto</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
require '../footer/footer.php';
?>
