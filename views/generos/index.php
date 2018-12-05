<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = 'Listado de géneros';
$this->params['breadcrumbs'][] = $this->title;
?>
<table class="table table-striped">
    <thead>
        <th>Género</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php foreach ($filas as $fila): ?>
            <tr>
                <td><?= Html::encode($fila['genero']) ?></td>
                <td>
                    <?= Html::a('Modificar', ['generos/update', 'id' => $fila['id']], ['class' => 'btn-xs btn-info']) ?>
                    <?= Html::a(
                        'Borrar',
                        ['generos/delete', 'id' => $fila['id']],
                        [
                            'class' => 'btn-xs btn-danger',
                            'data-confirm' => '¿Seguro que desea borrar el género?',
                            'data-method' => 'POST',
                        ]) ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="row">
    <div class="text-center">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>

<div class="row">
    <div class="text-center">
        <?= Html::a('Insertar un nuevo género', ['generos/create'], ['class' => 'btn btn-info']) ?>
    </div>
</div>
