<?php
use yii\helpers\Html;

extract($peliculasForm->getAttributes());

print_r($peliculasForm->errors);
?>

<?= Html::beginForm() ?>
    <div class="form-group">
        <?= Html::label('Título', 'titulo') ?>
        <?= Html::input('text', 'titulo', $titulo, ['class' => 'form-control', 'id' => 'titulo']) ?>
    </div>
    <div class="form-group">
        <?= Html::label('Año', 'anyo') ?>
        <?= Html::input('text', 'anyo', $anyo, ['class' => 'form-control', 'id' => 'anyo']) ?>
    </div>
    <div class="form-group">
        <?= Html::label('Duración', 'duracion') ?>
        <?= Html::input('text', 'duracion', $duracion, ['class' => 'form-control', 'id' => 'duracion']) ?>
    </div>
    <div class="form-group">
        <?= Html::label('Género', 'genero_id') ?>
        <?= Html::input('text', 'genero_id', $genero_id, ['class' => 'form-control', 'id' => 'genero_id']) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Insertar', ['class' => 'btn btn-primary']) ?>

    </div>
<?= Html::endForm() ?>
