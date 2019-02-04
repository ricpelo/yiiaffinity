<?php
use yii\helpers\Url;

$this->title = 'Prueba de AJAX';
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to(['site/dame-numero']);
$js = <<<EOF
    $('#boton').click(function () {
        var numero = $('#lista li').last().text();
        $.ajax({
            url: '$url',
            method: 'POST',
            data: { numero: numero },
            success: function (data, status, xhr) {
                $('#lista').append('<li>' + data + '</li>');
            }
        });
    });
EOF;
$this->registerJs($js);
?>
<h1><?= $this->title ?></h1>
<button id="boton" type="button" class="btn btn-primary">Púlsame</button>
<ul id="lista">
    <li>1</li>
</ul>
