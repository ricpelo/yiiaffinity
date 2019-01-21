<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PapelesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Papeles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="papeles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Papeles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'papel',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
