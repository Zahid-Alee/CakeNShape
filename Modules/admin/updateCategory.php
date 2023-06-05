<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="assets/css/admin.css"> -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
</head>

<body class="p-5">

    <h2 class="text-center font-weight-bold py-4">Update Category</h2>
    <?php
    use DataSource\DataSource;

    require_once __DIR__ . '../../../lib/DataSource.php';

    $con = new DataSource;

    if (isset($_GET['CategoryID'])) {

        // Retrieve the cake details based on the CakeID
        $query = 'SELECT * from categories where CategoryID=?';
        $paramType = 's'; // Assuming CakeID is an integer, change it accordingly if it's not
        $paramArray = array($_GET['CategoryID']);
        $categories = $con->select($query, $paramType, $paramArray);

        if (!empty($categories)) {
            // print_r($category);
    
            ?>

            <form method="POST" id='catUpdateForm' enctype="multipart/form-data">
                <!-- <input type="text" value="update"> -->
                <input type="hidden" name="CategoryID" value="<?php echo $categories[0]['CategoryID']; ?>">
                <input type="hidden" name="method" value="update">

                <div class="form-group">
                    <label for="CakeName"><i class="fas fa-user"></i> Category Name</label>
                    <input type="text" class="form-control" name="CategoryName"
                        value="<?php echo $categories[0]['CategoryName']; ?>">
                </div>


                <div class="form-group">
                    <label for="Image"><i class="fas fa-file"></i> Image</label>
                    <input type="file" class="form-control" name="Image">
                </div>

                <button type="submit" id="submit-btn" class="btn btn-danger closeModalBtn2 "><i class="fas fa-paper-plane"></i>
                    Submit</button>
            </form>

            <?php
        } else {
            echo "<strong>No cake found</strong>";
        }
    } else {
        echo "<strong>Invalid request</strong>";
    }
    ?>

    <script>
        const form = document.getElementById('catUpdateForm');
        form.addEventListener('submit', submitForm);
        async function submitForm(event) {
            event.preventDefault();
            const formValues = new FormData(event.target);
            await fetch('http://localhost/CakeNShape/Model/handleCategories.php', {
                method: 'POST',
                body: formValues
            })
                .then(response => response.text())
                .then(data => {
                    console.log('Success:', data);
                    location.reload();

                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>