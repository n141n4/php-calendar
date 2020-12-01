     <?php
        require '../views/header.php';
        require '../src/Calendar/Month.php';
        require '../src/Calendar/Events.php';

        try {
            $events = new App\Calendar\Events();
            $month = new App\Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
            $start = $month->getStartingDay();
            $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');

            $weeks = $month->getWeeks();
            $end  = (clone $start)->modify('+' .(6 + 7 * ($weeks - 1)). ' days');
            $events = $events->getEventsBetweenByDay($start, $end);

        } catch (\Exception $e) {
            $month = new App\Calendar\Month();
        }
     ?>
     <div class="container">
     <div class="d-flex flex-row  justify-content-between mt-4">
        <h3><?= $month->toString();?></h3>
        <div>
            <a href="/calendrier/public/index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary btn-sm">&lt;</a>
            <a href="/calendrier/public/index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary btn-sm" class="btn btn-primary btn-sm">&gt;</a>
        </div>
     </div>

     <div class="card shadow">
        <div class="card-body">
            <?php  for ($i = 0; $i < $weeks; $i++): ?>
                <table class="calendar__table calendar__table--<?= $weeks;?>weeks">
                    <tr>
                    <?php 
                    foreach ($month->days as $k => $day):
                        $date = (clone $start)->modify("+" . ($k + $i * 7) . "days");
                        $eventsforDay = $events[$date->format('Y-m-d')] ?? [];
                    ?>
                        <td class="<?= $month->withinMonth($date) ? ' ' : 'calendar__othermonth'; ?>">
                            <?php if ($i === 0): ?>
                                <div class="calendar__weekday">
                                    <?= $day; ?> 
                                </div>
                            <?php endif;?>
                            <div class="calendar__day">
                                <?= $date->format('d'); ?>
                            </div>
                            <?php foreach ($eventsforDay as $event):?>
                                <div class="calendar__event">
                                    <small>
                                    <?= (new DateTime($event['start']))->format('H:i')?> - 
                                    <a class="badge badge-primary" href="/calendrier/public/event.php?id=<?= $event['id'];?>"><?= $event['name'];?></a>
                                    
                                    </small>
                                </div>
                            <?php endforeach;?>
                        </td>
                    <?php endforeach;?>
                    </tr>
                </table>
            <?php endfor; ?>
        </div>
     </div>
   </div>
<?php require '../views/footer.php';?>