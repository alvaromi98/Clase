<?php
session_start();
echo $_SESSION["c"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Color</title>
</head>

<body bgcolor="<?php echo $_SESSION["c"] ?>">

</body>

</html>