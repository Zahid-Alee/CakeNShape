<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Passing PHP Variable to JavaScript Function</title>
</head>
<body>
    <?php
        $name = "John";
    ?>
    <button onclick="myFunction('<?php echo $name; ?>')">Click Me</button>
    <script>
        function myFunction(name) {
            alert("Hello, " + name + "!");
        }
    </script>
</body>
</html>
