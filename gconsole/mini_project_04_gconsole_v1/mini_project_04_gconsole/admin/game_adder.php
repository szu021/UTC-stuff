
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Game</title>
</head>
<body>

<h1>Add a Game</h1>

<!-- the form sends its data back to this same page using post -->
<form action="" method="post">
    <!-- the name of the game -->
    <label for="name">Game Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <!-- drop down box for picking the developer -->
    <label for="developer_id">Developer:</label><br>
    <select id="developer_id" name="developer_id" required>
        <option value="">Select a Developer</option>

    </select><br><br>

    <!-- drop down box for picking the publisher -->
    <label for="publisher_id">Publisher:</label><br>
    <select id="publisher_id" name="publisher_id" required>
        <option value="">Select a Publisher</option>

    </select><br><br>

    <!-- the button that sends the form -->
    <input type="submit" value="submit">
</form>

</body>
</html>