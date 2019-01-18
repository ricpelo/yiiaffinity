<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Insertar una nueva película';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($pelicula, 'titulo') ?>
    <?= $form->field($pelicula, 'anyo') ?>
    <?= $form->field($pelicula, 'sinopsis')->textarea() ?>
    <?= $form->field($pelicula, 'duracion') ?>
    <?= $form->field($pelicula, 'genero_id') ?>
    <div class="form-group">
        <?= Html::submitButton('Insertar película', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
