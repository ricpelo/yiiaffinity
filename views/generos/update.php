<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Modificar un género';
$this->params['breadcrumbs'][] = ['label' => 'Géneros', 'url' => ['generos/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($generosForm, 'genero')?>
    <div class="form-group">
        <?= Html::submitButton('Modificar género', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['generos/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
