<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;?>

    <div style="width: 22%;">
<? $form = ActiveForm::begin()?>
<?= $form->field($model,'username');?>
<?= $form->field($model,'password')->passwordInput();?>
<?= $form->field($model,'passwordReload')->passwordInput();?>
<?= $form->field($model,'isNotary')->radioList([
    '1' => 'Нотариус',//notary = 1
    '0' => 'Клиент']//client = 0
    );?>
<?= Html::submitButton('Sign Up',['class' => 'btn btn-success']);?>
<? ActiveForm::end()?>
</div>
