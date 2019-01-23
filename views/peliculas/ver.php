<?php
use yii\helpers\Html;

$this->title = 'Ver una película';
$this->params['breadcrumbs'][] = $this->title;
?>
<dl class="dl-horizontal">
    <dt>Título</dt>
    <dd><?= Html::encode($pelicula->titulo) ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Año</dt>
    <dd><?= Html::encode($pelicula->anyo) ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Duración</dt>
    <dd><?= Html::encode($pelicula->duracion) ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Género</dt>
    <dd><?= Html::encode($pelicula->genero->genero) ?></dd>
</dl>

<?php foreach ($participantes as $papel => $personas): ?>
    <dl class="dl-horizontal">
        <dt><?= Html::encode($papel) ?></dt>
        <?php foreach ($personas as $persona): ?>
            <dd><?= Html::encode($persona['nombre']) ?></dd>
        <?php endforeach ?>
    </dl>
<?php endforeach ?>
