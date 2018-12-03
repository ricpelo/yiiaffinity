<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Modificar un nuevo género';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($generosForm, 'genero') ?>
    <div class="form-group">
        <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>
