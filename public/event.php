<?php
        require '../views/header.php';
        require '../src/Calendar/Events.php';

        $events = new App\Calendar\Events();

        if (!isset($_GET['id'])) {
            header('location: /404.php');
        }
        $event = $events->find($_GET['id']);
?>

     <div class="container">
     <h3 class="mt-4">Mes évènements</h3>
        <div class="card shadow">
            <div class="card-body">

            </div>
        </div>
     </div>

<?php require '../views/footer.php';?>