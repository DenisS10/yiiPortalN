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
        <td>Цена</td>
        <td>Управление заказом</td>
        <td>Состояние заказа</td>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td><?=date('d.m.Y H:i:s',$allTask->creation_date)?></td>
            <td><?=date('d.m.Y H:i:s',$allTask->deadline_date)?></td>
            <td><?=$allTask->name?></td>
            <td><?=$allTask->sur_name?></td>
            <td><?=$allTask->price?></td>
        </tr>
    </tbody>
</table>
</body>
</html>