<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Películas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <table class="table table-striped">
        <thead>
            <th><?= $sort->link('titulo') ?></th>
            <th><?= $sort->link('duracion') ?></th>
            <th><?= $sort->link('anyo') ?></th>
            <th><?= $sort->link('genero') ?></th>
            <th>Sinopsis</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($filas as $fila): ?>
                <tr>
                    <td><?= Html::a(Html::encode($fila['titulo']), ['peliculas/ver', 'id' => $fila['id']]) ?></td>
                    <td><?= Html::encode($fila['duracion']) ?></td>
                    <td><?= Html::encode($fila['anyo']) ?></td>
                    <td><?= Html::a(Html::encode($fila['genero']), ['generos/update', 'id' => $fila['genero_id']]) ?></td>
                    <td><?= Html::encode($fila['sinopsis']) ?></td>
                    <td>
                        <?= Html::a('Modificar', ['peliculas/update', 'id' => $fila['id']], ['class' => 'btn-xs btn-info']) ?>
                        <?= Html::a('Borrar', ['peliculas/delete', 'id' => $fila['id']], [
                            'class' => 'btn-xs btn-danger',
                            'data-confirm' => '¿Seguro que desea borrar?',
                            'data-method' => 'POST',
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="text-center">
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>
<div class="row">
    <div class="text-center">
        <?= Html::a('Insertar película', ['peliculas/create'], ['class' => 'btn btn-info']) ?>
    </div>
</div>
