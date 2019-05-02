<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;?>

    <div style="width: 22%;">
<? $form = ActiveForm::begin()?>
<?= $form->field($model,'username');?>
<?= $form->field($model,'password')->passwordInput();?>
<?= $form->field($model,'passwordReload')->passwordInput();?>
<?= Html::submitButton('Sign Up',['class' => 'btn btn-success']);?>
<? ActiveForm::end()?>
</div>
