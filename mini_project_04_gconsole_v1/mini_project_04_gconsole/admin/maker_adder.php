
<!doctype html>
<html lang="en">
<head> <!-- The head of the page, usually has the title, which is the tab's name as well as the link to the stylesheet to decorate the website. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Manufacturer</title>

</head>
<body>

<h1>Gconsole</h1>
<h1>manufacturer adder</h1>

<!-- the form sends its data back to this same page using post -->
<form method="post" action="maker_adder.php">
    <div class="label_div">

        <!-- the name of the manufacturer -->
        <label for="name"><strong>manufacturer name:</strong></label>
        <input type="text" name="name" id="name" placeholder="name" required><br>

        <!-- where the manufacturer is based -->
        <label for="location"><strong>location:</strong></label>
        <input type="text" name="location" id="location" placeholder="location" required><br>

        <!-- the button that sends the form -->
        <button type="submit">add manufacturer</button>
    </div>

</form>

</body>
</html>
