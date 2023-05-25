<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Modules/users/user.css">
    <link rel="stylesheet" href="Modules/users/services.css">
    <link rel="stylesheet" href="Modules/users/categories.css">
    <link rel="stylesheet" href="Modules/users/header.css">
    <link rel="stylesheet" href="Modules/users/products.css">


    <title>Document</title>
</head>

<body>
    <?php include('./Modules/users/header.php') ?>

    <div class='userPage'>
        <?php include('./Modules/users/services.php') ?>
        <?php include('./Modules/users/categories.php') ?>
        <?php include('./Modules/users/products.php') ?>
        <?php include('./Modules/users/reviews.php') ?>
    </div>

    <?php include('./Modules/users/footer.php') ?>

</body>
<script>
</script>

</html>