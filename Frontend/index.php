<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
</head>
<style>
    .container-main{
        display : flex;
        flex-direction: column;
        gap : 10px;
        align-items: center;
    }
    ul {
        list-style-type: none; 
        padding: 0;
        margin: 0;
    }
</style>
<body>
    <?php $port = "5170"?>
    <ul class="container-main">
        <li><?php include "View_tasks.php"?></li>
        <li><?php include "Add_task.php"?></li>
        <li><?php include "Manage_task.php"?></li>
    </ul> 
    
    
</body>


</html>
