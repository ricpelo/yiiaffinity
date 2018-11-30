<?php
use yii\helpers\Html;
?>
<div class="row">
    <table class="table table-striped">
        <thead>
            <th>Título</th>
            <th>Año</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($filas as $fila): ?>
                <tr>
                    <td><?= Html::encode($fila['titulo']) ?></td>
                    <td><?= Html::encode($fila['anyo']) ?></td>
                    <td>
                        <?= Html::a('Modificar', ['prueba/modificar', 'id' => $fila['id']], ['class' => 'btn-xs btn-info']) ?>
                        <?= Html::a('Borrar', ['prueba/borrar', 'id' => $fila['id']], [
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
        <?= Html::a('Insertar película', ['prueba/insertar'], ['class' => 'btn btn-info']) ?>
    </div>
</div>
