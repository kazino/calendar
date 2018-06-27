<?php
require '../src/bootstrap.php';

use Calendar\Events;
use Calendar\Month;

$pdo = get_pdo();
$events = new Events($pdo);
/*$month = new Month($_GET['month' ] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay()->modify('last monday');
$start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');*/
$start = new DateTimeImmutable('first day of january');
$end = $start->modify('last day of december')->modify('+ 1 day');
$events = $events->getEventsBetween($start, $end);
?>

id,name,start,end
<?php foreach ($events as $event): ?>
<?= $event->getId(); ?> - "<?= addslashes($event->getName()); ?>" - "<?= $event->getStart()->format('Y-m-d'); ?>" - "<?= $event->getEnd()->format('Y-m-d'); ?>"
<?php endforeach; ?>


