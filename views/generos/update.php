<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Modificar un nuevo género';
$this->params['breadcrumbs'][] = ['label' => 'Géneros', 'url' => ['generos/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($genero, 'genero') ?>
    <div class="form-group">
        <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['generos/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
