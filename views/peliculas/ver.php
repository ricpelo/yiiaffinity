<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Ver una película';
$this->params['breadcrumbs'][] = $this->title;
$inputOptions = [
    'inputOptions' => [
        'class' => 'form-control',
        'readonly' => true,
    ],
];
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($peliculasForm, 'titulo', $inputOptions) ?>
    <?= $form->field($peliculasForm, 'anyo', $inputOptions) ?>
    <?= $form->field($peliculasForm, 'duracion', $inputOptions) ?>
    <?= $form->field($peliculasForm, 'genero_id', $inputOptions) ?>
    <div class="form-group">
        <?= Html::a('Volver', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
