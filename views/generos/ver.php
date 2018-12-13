<?php
use yii\helpers\Html;
$this->title = 'Ver un género';
$this->params['breadcrumbs'][] = ['label' => 'Géneros', 'url' => ['generos/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h2><?= $genero['genero'] ?></h2>
<table class="table">
    <thead>
        <th>Título</th>
        <th>Año</th>
        <th>Duración</th>
    </thead>
    <tbody>
        <?php foreach ($peliculas as $pelicula): ?>
            <tr>
                <td><?= Html::encode($pelicula['titulo']) ?></td>
                <td><?= Html::encode($pelicula['anyo']) ?></td>
                <td><?= Html::encode($pelicula['duracion']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
