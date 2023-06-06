<?php
use DataSource\DataSource;

require_once __DIR__ . '../../../lib/DataSource.php';

$con = new DataSource;
$query = 'SELECT *
          FROM Sales
          JOIN Orders ON Sales.OrderID = Orders.OrderID
          JOIN Users ON Orders.userID = Users.userID';
$sales = $con->select($query);

if (!empty($sales)) {
    foreach ($sales as $sale) {
        $orderID = $sale['OrderID'];
        $query = "SELECT c.CakeName, c.MaterialUsed, c.Flavor, c.Weight, c.Price
                  FROM Order_Items AS oi
                  JOIN Cakes AS c ON oi.CakeID = c.CakeID
                  WHERE oi.OrderID = ?";
        $paramType = "i";
        $paramValue = array($orderID);
        $saleItems = $con->select($query, $paramType, $paramValue);
        ?>
        <tr>
            <td scope="row" class='text-center'>
                <?php echo $sale['username']; ?>
            </td>
            <td scope="row" class='text-center'>
                <?php echo $saleItems ? count($saleItems) : 0; ?>
            </td>
            <td class='text-center'>
                <?php echo $sale['PaymentMethod']; ?>
            </td>
            <td class='text-center'>
                <?php echo $sale['OrderDate']; ?>
            </td>
            <td class='text-center'>
                <?php echo $sale['DeliveryDate']; ?>
            </td>
            <td class='text-center'>
                <!-- Actions -->
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <?php if ($saleItems) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class='text-center'>Cake Name</th>
                                <th scope="col" class='text-center'>Material Used</th>
                                <th scope="col" class='text-center'>Flavor</th>
                                <th scope="col" class='text-center'>Weight</th>
                                <th scope="col" class='text-center'>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($saleItems as $item) {
                                ?>
                                <tr>
                                    <td class='text-center'>
                                        <?php echo $item['CakeName']; ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php echo $item['MaterialUsed']; ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php echo $item['Flavor']; ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php echo $item['Weight']; ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php echo $item['Price']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo "<p>No sale items found</p>";
                } ?>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<strong>No sales found</strong>";
}
?>
