<?php
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;

$this->title = 'Listado de películas';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Listado de películas</h1>

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
        'genero.genero',
        [
            'class' => ActionColumn::class,
            'header' => 'Acciones',
        ],
    ],
]) ?>
