<div class="container">
    <h3 class="py-4 text-center font-weight-bold">Cake Sales Records</h3>
    <!-- <div class="filters">
        <label for="year">Year:</label>
        <select id="year">
            <option value="">All</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
        </select>
        <label for="month">Month:</label>
        <select id="month">
            <option value="">All</option>
            <option value="1">January</option>
            <option value="2">February</option>
        </select>
    </div> -->
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Cake Name</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody id="salesTableBody">
            <!-- Sales records will be dynamically added here -->
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total Sales Bill:</th>
                <th id="totalBill"></th>
            </tr>
            <th colspan="4" class="text-end">Total Sold Quantity:</th>
            <th id="totalQuantity"></th>

        </tfoot>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        loadSalesData();
    });

    $('#year, #month').change(function () {
        loadSalesData();
    });

    function loadSalesData() {
        const year = $('#year').val();
        const month = $('#month').val();

        $.ajax({
            url: 'Model/salesData.php',
            type: 'GET',
            data: { year: year, month: month },
            dataType: 'json',
            success: function (data) {
                populateSalesTable(data);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching sales data:', error);
            }
        });
    }

    function populateSalesTable(data) {
        const salesTableBody = $('#salesTableBody');
        salesTableBody.empty();

        let totalBill = 0;
        let totalQuantity = 0;

        data.forEach(function (record) {
            const row = $('<tr>');
            row.append($('<td>').text(record.OrderID));
            row.append($('<td>').text(record.OrderDate));
            row.append($('<td>').text(record.CakeName));
            row.append($('<td>').text(record.Quantity));
            row.append($('<td>').text(record.Subtotal));
            salesTableBody.append(row);

            totalBill += parseFloat(record.Subtotal);
            totalQuantity += parseFloat(record.Quantity);

        });

        const totalBillField = $('#totalBill');
        const totalQuantityField = $('#totalQuantity');


        totalBillField.text(totalBill.toFixed(2));
        totalQuantityField.text(totalQuantity.toFixed(2));

    }
</script>