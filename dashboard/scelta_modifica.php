<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../header/header.php';
require_once '../DbConnection.php';

$config = require '../DBconfig.php';

$db = artifex\Db_connection::getDB($config);
?>
    <div class="container">
        <h1 class="title">Eventi per le guide:</h1>
        <div class="button-group">
            <a href="create_guida.php"><button>Inserisci guida</button></a>
            <a href="read_guida.php"><button>Visualizza tutte le guide</button></a>
            <a href="update_guida.php"><button>Aggiorna tutte le guide</button></a>
        </div>

        <h1 class="title">Eventi per gli eventi:</h1>
        <div class="button-group">
            <a href="create_evento.php"><button>Inserisci evento</button></a>
            <a href="modifica_evento.php"><button>Aggiorna un evento</button></a>
            <a href="../eventi_lista/event_lista.php"><button>Visualizza eventi</button></a>
        </div>
    </div>

<?php
require '../footer/footer.php';
