<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Papeles */

$this->title = 'Create Papeles';
$this->params['breadcrumbs'][] = ['label' => 'Papeles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="papeles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
