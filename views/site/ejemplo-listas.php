<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Ejemplo de listas con AJAX';
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to(['site/municipios']);
$js = <<<EOF
    $('#provincia').change(function() {
        var provincia = $(this).val();
        $.ajax({
            url: '$url',
            method: 'GET',
            data: { provincia: provincia },
            success: function (data, status, xhr) {
                $('#municipios').empty();
                data.forEach(function (valor, indice, array) {
                    $('#municipios').append($('<option>', {
                        value: indice,
                        text: valor
                    }));
                });
            }
        });
    });
EOF;
$this->registerJs($js);
?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin(['id' => 'formulario']) ?>
    <?= $form->field($listasForm, 'provincia', [
        'inputOptions' => [
            'id' => 'provincia',
            'class' => 'form-control',
        ],
    ])->dropDownList($provincias) ?>
    <?= $form->field($listasForm, 'municipio', [
        'inputOptions' => [
            'id' => 'municipios',
            'class' => 'form-control',
        ],
    ])->dropDownList($municipios) ?>
<?php ActiveForm::end() ?>
