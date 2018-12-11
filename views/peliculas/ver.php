<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Ver películas';
$this->params['breadcrumbs'][] = $this->title;
// Así se insertan estilos css
// $css = <<<EOF
//
// EOF;
// $this->registerCss($css);
?>
<div class="row">
    <table class="table">
        <tr>
            <td align="right"><strong>Titulo</strong></td>
            <td><?= Html::encode($pelicula['titulo']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Año</strong></td>
            <td><?= Html::encode($pelicula['anyo']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Duracíon</strong></td>
            <td><?= Html::encode($pelicula['duracion']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Género</strong></td>
            <td><?= Html::encode($pelicula['genero']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Sinopsis</strong></td>
            <td><?= Html::encode($pelicula['sinopsis']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Participantes</strong></td>
            <td>
            <?php foreach ($participantes as $participante):
                Html::encode($participante['nombre']) . '(' . Html::encode($participante['rol']) . ')' ?><br>
            <?php endforeach ?>
            </td>
        </tr>
    </table>
</div>
