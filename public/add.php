<?php
require '../src/bootstrap.php';

$data = [
    'date' => $_GET['date'] ?? date('Y-m-d'),
    'start' => date('H:i'),
    'end' => date('H:i')
];
$validator = new \App\Validator();
if (!$validator->validate('date', 'date')){
    $data['date'] = date('Y-m-d');
};
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($_POST);
    if (empty($errors)) {
        $events = new \Calendar\Events(get_pdo());
        $event = $events->hydrate(new \Calendar\Event(), $data);
        $events->create($event);
        header('Location: /index?success=1');
        exit();
    }
}

render('header', ['title' => 'Ajouter un évènement']);

?>
<div class="container">
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Merci de corriger vos erreurs
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <h1>Ajouter un évènement</h1>
    <hr>
    <form action="" method="post">
        <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>

<?php render('footer'); ?>
