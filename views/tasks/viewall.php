<?
/** @var $allTasks  */
?>
<html>
<head>

</head>
<body>
<table class="table table-bordered">
    <thead>
        <tr>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Скачать файл</td>
        </tr>
    </thead>
    <tbody>
    <? foreach ($allTasks as $allTask) {
//        echo '<pre>';
//        print_r($allTask);
//        exit();
    ?>
    <tr>
        <td><?=$allTask->name?></td>
        <td><?=$allTask->sur_name?></td>
        <td><a href="/tasks/download/<?=$allTask->file_key?>"><?='Скачать'?></a></td>
        <td><button></button></td>
    </tr>
    <?}?>
    </tbody>
</table>
</body>
</html>