<?php
/** @var $model */
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div style="width: 22%;">
    <? $form = ActiveForm::begin()?>
    <?= $form->field($model, 'userFile')->fileInput() ?>
    <?= Html::submitButton('Send',['class' => 'btn btn-success']);?>
    <? ActiveForm::end()?>

</div>