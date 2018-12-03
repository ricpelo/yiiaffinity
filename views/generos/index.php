<?php
use yii\helpers\Html;
?>
<div class="row">
    <table class="table table-striped">
        <thead>
            <th>Género</th>
        </thead>
        <tbody>
            <?php foreach ($filas as $fila): ?>
                <tr>
                    <td><?= Html::encode($fila['genero']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="text-center">
        <?= Html::a('Insertar un nuevo género', ['generos/create'], ['class' => 'btn btn-info']) ?>
    </div>
</div>
