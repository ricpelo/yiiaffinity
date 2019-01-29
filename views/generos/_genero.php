<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'genero',
    ],
]) ?>
