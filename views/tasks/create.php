<?php
/** @var $model */
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div style="width: 22%;">
    <? $form = ActiveForm::begin()?>
    <?= $form->field($model,'name');?>
    <?= $form->field($model,'surName');?>
<!--    <?//= $form->field($model,'deadline');?>-->

    <?= $form->field($model, 'deadline')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99.99.2099 99:99',
    ]) ?>
    <?= $form->field($model, 'price')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99',
    ]) ?>

<!--    --><?//= $form->field($model,'price');?>
    <?= $form->field($model, 'userFile')->fileInput() ?>

    <?= Html::submitButton('Send',['class' => 'btn btn-success']);?>
    <? ActiveForm::end()?>
<!--    --><?//echo '<pre>';
//    print_r($model);
//    echo '//////////////////////////////////////////////////////';
//    print_r($_FILES);
//    exit();?>
</div>
