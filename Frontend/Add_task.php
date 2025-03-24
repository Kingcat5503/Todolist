<?php
$message = ""; // Store success or error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $task = $_POST['task'];

    // Validate input
    if (empty($id) || !is_numeric($id)) {
        $message = "❌ Invalid ID. It must be a number.";
    } elseif (empty($task) || strlen($task) < 3) {
        $message = "❌ Invalid task. Must be at least 3 characters.";
    } else {
        // Prepare data
        $api_url = "http://localhost:$port/todos/$id"; // .NET API URL
        $data = json_encode(["task" => $task, "isComplete" => false]);

        // Send API request
        $options = [
            "http" => [
                "header"  => "Content-Type: application/json",
                "method"  => "POST",
                "content" => $data
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($api_url, false, $context);

        if ($response === false) {
            $message = "❌ Error adding task.";
        } else {
            $message = "✅ Task added successfully.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
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
            width: 300px;
            margin: auto;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Add a Task</h2>
    
    <form method="POST">
        <input type="number" name="id" placeholder="Enter Task ID" required>
        <input type="text" name="task" placeholder="Enter Task" required>
        <button type="submit">Add Task</button>
    </form>

    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
</div>

</body>
</html>
