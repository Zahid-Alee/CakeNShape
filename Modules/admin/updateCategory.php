<?php
use DataSource\DataSource;

require_once __DIR__ . '../../../lib/DataSource.php';

$con = new DataSource;

if (isset($_GET['CakeID'])) {

    // Retrieve the cake details based on the CakeID
    $query = 'SELECT CakeID, CakeName, CategoryName, cakes.CategoryID, MaterialUsed, Flavor, Weight, Price, Image, Quantity FROM cakes INNER JOIN categories ON categories.CategoryID = cakes.CategoryID WHERE CakeID = ?';
    $paramType = 's'; // Assuming CakeID is an integer, change it accordingly if it's not
    $paramArray = array($_GET['CakeID']);
    $cake = $con->select($query, $paramType, $paramArray);

    if (!empty($cake)) {
        print_r($cake);

        ?>

        <form method="POST" id='cakeUpdateForm'>
            <input type="hidden" name="CakeID" value="<?php echo $cake[0]['CakeID']; ?>">
            <input type="hidden" name="method" value="update">

            <div class="form-group">
                <label for="CakeName"><i class="fas fa-user"></i> Cake Name</label>
                <input type="text" class="form-control" name="CakeName" value="<?php echo $cake[0]['CakeName']; ?>">
            </div>
            <div class="form-group">
                <label for="MaterialUsed"><i class="fas fa-male"></i> Material Used</label>
                <input type="text" class="form-control" name="MaterialUsed" value="<?php echo $cake[0]['MaterialUsed']; ?>">
            </div>

            <div class="form-group">
                <label for="CategoryID"><i class="fas fa-notes-medical"></i> Category</label>
                <select class="form-control" name="CategoryID">
                    <option value="<?php echo $cake[0]['CategoryID']; ?>" selected><?php echo $cake[0]['CategoryName']; ?>
                    </option>
                    <?php
                    $query = 'SELECT * FROM Categories';
                    $categories = $con->select($query);
                    if (!empty($categories)) {
                        foreach ($categories as $cat) {
                            if ($cat['CategoryID'] !== $cake[0]['CategoryID']) {
                                echo '<option value="' . $cat['CategoryID'] . '">' . $cat['CategoryName'] . '</option>';
                            }
                        }
                    } else {
                        echo "<strong>No Categories !</strong>";
                    }
                    ?>
                </select>

            </div>
            <div class="form-group">
                <label for="Weight"><i class="fas fa-male"></i> Weight</label>
                <input type="number" class="form-control" name="Weight" value="<?php echo $cake[0]['Weight']; ?>">
            </div>
            <div class="form-group">
                <label for="Flavor"><i class="fas fa-male"></i> Flavor</label>
                <input type="text" class="form-control" name="Flavor" value="<?php echo $cake[0]['Flavor']; ?>">
            </div>
            <div class="form-group">
                <label for="Price"><i class="fas fa-price"></i> Price</label>
                <input type="number" class="form-control" name="Price" value="<?php echo $cake[0]['Price']; ?>">
            </div>
            <div class="form-group">
                <label for="Quantity"><i class="fas fa-price"></i> Quantity</label>
                <input type="number" class="form-control" name="Quantity" value="<?php echo $cake[0]['Quantity']; ?>">
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
    const form = document.getElementById('cakeUpdateForm');
    form.addEventListener('submit', submitForm);
    async function submitForm(event) {
        event.preventDefault();
        const formValues = new FormData(event.target);
        await fetch('http://localhost/CakeNShape/Model/handleCakeStock.php', {
            method: 'POST',
            body: formValues
        })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
</script>