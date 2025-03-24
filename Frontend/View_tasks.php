<?php
$api_url = "http://localhost:$port/todos"; // .NET API URL
$response = file_get_contents($api_url);
$todos = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        .todo {
            background: #e0e0e0;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
        }
        .completed {
            background: #90ee90;
            text-decoration: line-through;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Todo List</h2>
    <?php
    if ($todos) {
        foreach ($todos as $todo) {
            $completedClass = $todo['isComplete'] ? 'completed' : '';
            echo "<div class='todo $completedClass'>";
            echo "<strong>ID:</strong> " . $todo['id'] . "<br>";
            echo "<strong>Task:</strong> " . htmlspecialchars($todo['task']) . "<br>";
            echo "<strong>Status:</strong> " . ($todo['isComplete'] ? "✅ Completed" : "❌ Pending");
            echo "</div>";
        }
    } else {
        echo "<p>No tasks found.</p>";
    }
    ?>
</div>
<script>
    function fetchTodos() {
        fetch('http://localhost:5170/todos') // Change this URL to match your API
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById('todo-list');
                list.innerHTML = ''; // Clear the current list
                data.forEach(todo => {
                    const li = document.createElement('li');
                    li.textContent = `${todo.id}: ${todo.title} - ${todo.completed ? '✅ Done' : '⏳ Pending'}`;
                    list.appendChild(li);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fetch todos immediately and then every 5 seconds
    fetchTodos();
    setInterval(fetchTodos, 5000);
</script

</body>
</html>
