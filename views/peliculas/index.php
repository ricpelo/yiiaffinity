<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Listado de películas';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php var_dump($sort->orders) ?>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($buscarForm, 'titulo') ?>
    <?= $form->field($buscarForm, 'genero_id')->dropDownList($listaGeneros) ?>
    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>

<h1>Listado de películas</h1>
<table class="table table-striped">
    <thead>
        <th>#</th>
        <th><?= $sort->link('titulo') ?></th>
        <th><?= $sort->link('anyo') ?></th>
        <th><?= $sort->link('duracion') ?></th>
        <th><?= $sort->link('genero') ?></th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $total = 0;
        ?>
        <?php foreach ($peliculas as $pelicula): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= Html::a(Html::encode($pelicula->titulo), ['peliculas/ver', 'id' => $pelicula->id]) ?></td>
                <td><?= Html::encode($pelicula->anyo) ?></td>
                <td><?= Html::encode($pelicula->duracion) ?></td>
                <td><?= Html::encode($pelicula->genero->genero) ?></td>
                <td>
                    <?= Html::a('Modificar', ['peliculas/update', 'id' => $pelicula->id], ['class' => 'btn-xs btn-info']) ?>
                    <?= Html::a('Borrar', ['peliculas/delete', 'id' => $pelicula->id], [
                        'class' => 'btn-xs btn-danger',
                        'data-confirm' => '¿Seguro que desea borrar?',
                        'data-method' => 'POST',
                    ]) ?>
                </td>
            </tr>
            <?php $total += $pelicula->duracion ?>
        <?php endforeach ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><?= Html::encode($total) ?></td>
        </tr>
    </tbody>
</table>
<div class="row">
    <div class="text-center">
        <?= Html::a('Insertar película', ['peliculas/create'], ['class' => 'btn btn-info']) ?>
    </div>
</div>
