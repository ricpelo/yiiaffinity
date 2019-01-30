<?php
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use kartik\number\NumberControl;
use yii\helpers\Html;

use yii\web\View;

$this->title = 'Listado de películas';
$this->params['breadcrumbs'][] = $this->title;
$js = <<<EOF
    $('#boton').click(function (ev) {
        ev.preventDefault();
        alert('hola');
    });
EOF;
$this->registerJs($js);
?>
<h1>Listado de películas</h1>

<button id="boton" type="button" name="button">Púlsame</button>

<?= NumberControl::widget([
    'name' => 'prueba',
    'value' => 1200,
    'maskedInputOptions' => [
        'suffix' => ' €',
        'groupSeparator' => '.',
        'radixPoint' => ','
    ],
]) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'titulo',
        'anyo',
        'precio:currency',
        [
            'attribute' => 'duracion',
            'value' => function ($model) {
                return $model->duracion * 60;
            },
            'format' => 'duration',
        ],
        [
            'attribute' => 'genero.genero',
            'value' => function ($model) {
                return Html::a(
                    Html::encode($model->genero->genero),
                    ['generos/ver', 'id' => $model->genero->id]
                );
            },
            'format' => 'raw',
        ],
        [
            'class' => ActionColumn::class,
            'header' => 'Acciones',
        ],
    ],
]) ?>
