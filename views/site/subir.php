<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <button class="btn btn-success">Submit</button>
<?php ActiveForm::end() ?>
