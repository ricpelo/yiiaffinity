<?php
use app\models\Peliculas;

use yii\helpers\Html;
$this->title = 'Gestión de participaciones en una película';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Participantes en la película <?= Html::encode($pelicula->titulo) ?></h1>
<table class="table table-striped">
    <thead>
        <th>Persona</th>
        <th>Papel</th>
        <th>Quitar</th>
    </thead>
    <tbody>
        <?php foreach ($participaciones as $participacion): ?>
            <tr>
                <td><?= Html::encode($participacion->persona->nombre) ?></td>
                <td><?= Html::encode($participacion->papel->papel) ?></td>
                <td><?= Html::a(
                    'Quitar',
                    [
                        'participaciones/delete',
                        'pelicula_id' => $participacion->pelicula_id,
                        'persona_id' => $participacion->persona_id,
                        'papel_id' => $participacion->papel_id,
                    ],
                    ['class' => 'btn-xs btn-danger']
                ) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
