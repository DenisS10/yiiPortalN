<? /** @var $clientTasks
 */ ?>
<html>
<head>

</head>
<body>
<table class="table table-bordered">
    <thead>
    <tr>
        <td>Дата подачи заказа</td>
        <td>Крайний срок выполнения заказа</td>
        <td>Имя</td>
        <td>Фамилия</td>
        <!--        <td>Цена</td>-->
        <td>Управление заказом</td>
        <td>Скачать файл</td>
        <td>Состояние заказа</td>
        <td>Статус заказа</td>
    </tr>
    </thead>
    <tbody>
    <? $i = 0;
    foreach ($clientTasks as $clientTask) {

        $idDb = $clientTasks[$i]->id;
        $i++;
        ?>
        <tr>
        <td><?= date('d.m.Y H:i:s', $clientTask->creation_date) ?></td>
        <td><?= date('d.m.Y H:i:s', $clientTask->deadline_date) ?></td>
        <td><?= $clientTask->name ?></td>
        <td><?= $clientTask->sur_name ?></td>
        <!--            <td>--><? //= $clientTask->price ?><!--</td>-->
        <td><? if ($clientTask->is_deleted == 0) { ?>
                <a href="delete?id=<?= $idDb ?>" class="btn btn-danger">Отозвать заказ</a>
            <? } else { ?>
                <a href="delete?id=<?= $idDb ?>" class="btn btn-success">Восстановить заказ</a>
            <? } ?>
        </td>
        <td><a href="/tasks/download?key=<?= $clientTask->file_key ?>"><?= 'Скачать' ?></a></td>
        <td><? if ($clientTask->notary_name != 'no notary' && $clientTask->is_accepted == 1)
                echo 'Ваша заказ принял нотариус: ' . $clientTask->notary_name;
            else
                echo 'В данный момент заказ не был принят';

            ?></td>
        <td>             <?
        if ($clientTask->is_ready == 1)
            echo 'Заказ готов!';
        elseif ($clientTask->is_ready == 0)
            ?></td>
            </tr>
        <? } ?>
    </tbody>
</table>
</body>
</html>