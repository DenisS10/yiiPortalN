<?php
/** @var $model */
use yii\helpers\Html;
use yii\widgets\ActiveForm;


    ?>


    <?if(Yii::$app->session->hasFlash('nouser')) {?>
        <div style="width: 50%" class="alert alert-danger" role="alert">
            <?=Yii::$app->session->getFlash('nouser')?>
        </div>
    <?}?>
<div style="width: 22%;">
<? $form = ActiveForm::begin()?>
<?= $form->field($model,'login');?>
<?= $form->field($model,'password')->passwordInput();?>
<?= Html::submitButton('Login',['class' => 'btn btn-success']);?>
<? ActiveForm::end()?>
</div>
