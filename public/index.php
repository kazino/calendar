<!DOCTYPE HTML>
<html>
<head>
    <title>Calendar</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/calendar.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-primary mb-3">
    <a href="../public/index.php" class="navbar-brand">Mon Calendrier</a>
</nav>

<?php
require '../src/Calendar/Month.php';
require '../src/Calendar/Events.php';

$events = new Calendar\Events();
try{
    $month = new Calendar\Month($_GET['month' ] ?? null, $_GET['year'] ?? null);
}catch (\Exception $e){
    $month = new Calendar\Month();
}
$start = $month->getStartingDay()->modify('last monday');
$start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = (clone $start)->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');
$events = $events->getEventsBetweenByDay($start, $end);
/*echo '<pre>';
print_r($events);
echo '</pre>';*/
?>

<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
    <h1><?= $month->toString(); ?></h1>
    <div>
        <a href="./index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
        <a href="./index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
    </div>
</div>


<table class="calendar__table calendar__table--<?= $weeks; ?>Weeks">
    <?php for ($i = 0; $i < $weeks; $i++): ?>
        <tr>
            <?php foreach ($month->days as $k => $day):
                $date = (clone $start)->modify("+" . ($k + $i * 7) ." days");
                $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                ?>
            <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                <?php if ($i === 0): ?>
                    <div class="calendar__weekday"><?= $day; ?></div>
                <?php endif; ?>
                <div class="calendar__day"><?= $date->format('d'); ?></div>
                <?php foreach ($eventsForDay as $event): ?>
                    <div class="calendar__event">
                        <?= (new DateTime($event['start']))->format('H:i');?> - <?= $event['name'];?>
                    </div>
                <?php endforeach; ?>
            </td>
            <?php endforeach; ?>
        </tr>
    <?php endfor; ?>
</table>

</body>
</html>