<?
/** @var $allTasks  */

use yii\bootstrap\Alert;

?>
<html>
<head>

</head>
<body>
<table class="table table-bordered">
    <thead>
        <tr>
            <td>Дата подачи заказа</td>
            <td>Дата окончания актуальности заказа</td>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Цена</td>
            <td>Файл</td>
            <td>Управление заказами</td>
            <td>Состояние заказа</td>
        </tr>
    </thead>
    <tbody>
    <?$i=0;
    foreach ($allTasks as $allTask) {

        $idDb = $allTasks[$i]->id;
        $i++;

        if($allTask->is_deleted == 0){
    ?>
    <tr>
        <td><?=date('d.m.Y H:i:s',$allTask->creation_date)?></td>
        <td><?=date('d.m.Y H:i:s',$allTask->deadline_date)?></td>
        <td><?=$allTask->name?></td>
        <td><?=$allTask->sur_name?></td>
        <td><?=$allTask->price?></td>
        <td>
            <a href="/tasks/download?key=<?=$allTask->file_key?>"><?='Скачать'?></a>
<!--            <a href="/file/download?key=--><?//=$file->file_key?><!--">Download file</a>-->
<!--            <a href="/tasks/viewfile/?id=--><?//=$allTask->file_key?><!--">--><?//='Просмотреть'?><!--</a>-->
        </td>
        <td>
            <?if($allTask->is_accepted == 0){?>
            <a href="accept?id=<?= $idDb ?>" class="btn btn-success">Принять заказ</a>
        <?}elseif($allTask->is_accepted == 1 && $allTask->notary_id == Yii::$app->session->get('__id')){?>
            <a href="deny?id=<?= $idDb ?>" class="btn btn-danger">Отказаться</a>
            <?}else{?>
             <a disabled="disabled" class="btn btn-success">Невозможно принять заказ</a>

                <?}?>
        </td>
        <td><?if($allTask->is_accepted == 1){?>
            <?='Заказ принял нотариус: '.$allTask->notary_name?>
        <?}else{?>
            <?='Еще никто не взялся за работу!'?>
        <?}?>
        </td>
    </tr>
    <?}}?>
    </tbody>
</table>
</body>
</html>