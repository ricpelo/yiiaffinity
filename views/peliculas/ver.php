<?php
use yii\helpers\Html;

$this->title = 'Ver película';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
        <table class="table">
            <tr>
                <td align="right"><strong>Título</strong></td>
                <td><?= Html::encode($pelicula['titulo']) ?></td>
            </tr>
            <tr>
                <td align="right"><strong>Año</strong></td>
                <td><?= Html::encode($pelicula['anyo']) ?></td>
            </tr>
            <tr>
                <td align="right"><strong>Duración</strong></td>
                <td><?= Html::encode($pelicula['duracion']) ?></td>
            </tr>
            <tr>
                <td align="right"><strong>Género</strong></td>
                <td><?= Html::encode($pelicula['genero']) ?></td>
            </tr>
            <tr>
                <td align="right"><strong>Participantes</strong></td>
                <td>
                    <?php foreach ($participantes as $participante): ?>
                        <?= Html::encode($participante['nombre']) . ' (' .
                        Html::encode($participante['rol']) . ')' ?>
                        <br>
                    <?php endforeach ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <?= Html::a('Volver', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
</div>
