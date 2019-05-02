<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;?>

<div style="width: 22%;">
    <? $form = ActiveForm::begin()?>
    <?= $form->field($model,'oldPass')->passwordInput();?>
    <?= $form->field($model,'newPass')->passwordInput();?>
    <?= $form->field($model,'repeatNewPass')->passwordInput();?>
    <?= Html::submitButton('Change password',['class' => 'btn btn-primary']);?>
    <? ActiveForm::end()?>
</div>
<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;?>
<!---->
<!--<div style="width: 22%;">-->
<!--    --><?// $form = ActiveForm::begin()?>
<!--    --><?//= $form->field($model,'oldPass');?>
<!--    --><?//= $form->field($model,'newPass')->passwordInput();?>
<!--    --><?//= $form->field($model,'repeatNewPass')->passwordInput();?>
<!--    --><?//= Html::submitButton('Login',['class' => 'btn btn-success']);?>
<!--    --><?// ActiveForm::end()?>
<!--</div>-->
<!--/*    public function getTasks()-->
<!--{-->
<!--return $this->hasMany(Task::className(), ['user_id' => 'id']);-->
<!--}-->
<!---->
<!---->
<!--}*/-->