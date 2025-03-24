<?php
$api_url = "http://localhost:$port/todos"; // .NET API URL
$response = file_get_contents($api_url);
$todos = json_decode($response, true);

// Handle Task Completion (PUT Request)
if (isset($_POST['complete'])) {
    $id = $_POST['id'];
    $task = $_POST['task']; // Keep the same task
    $data = json_encode(["task" => $task, "isComplete" => true]);

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json",
            "method"  => "PUT",
            "content" => $data
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents("$api_url/$id", false, $context);
    header("Location: manage_todos.php"); // Refresh page
}

// Handle Task Deletion (DELETE Request)
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    
    $options = [
        "http" => [
            "method" => "DELETE"
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents("$api_url/$id", false, $context);
    header("Location: manage_todos.php"); // Refresh page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Todos</title>
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
        button {
            padding: 5px 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .complete-btn {
            background-color: #28a745;
            color: white;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Manage Todo List</h2>
    
    <?php
    if ($todos) {
        foreach ($todos as $todo) {
            $completedClass = $todo['isComplete'] ? 'completed' : '';
            echo "<div class='todo $completedClass'>";
            echo "<strong>ID:</strong> " . $todo['id'] . "<br>";
            echo "<strong>Task:</strong> " . htmlspecialchars($todo['task']) . "<br>";
            echo "<strong>Status:</strong> " . ($todo['isComplete'] ? "✅ Completed" : "❌ Pending") . "<br>";

            // Complete Button
            if (!$todo['isComplete']) {
                echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . $todo['id'] . "'>
                        <input type='hidden' name='task' value='" . htmlspecialchars($todo['task']) . "'>
                        <button type='submit' name='complete' class='complete-btn'>✅ Mark Complete</button>
                      </form>";
            }

            // Delete Button
            echo "<form method='POST' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $todo['id'] . "'>
                    <button type='submit' name='delete' class='delete-btn'>🗑️ Delete</button>
                  </form>";

            echo "</div>";
        }
    } else {
        echo "<p>No tasks found.</p>";
    }
    ?>
</div>

</body>
</html>
