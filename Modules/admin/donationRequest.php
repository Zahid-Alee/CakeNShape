<div class="alerts-notifications">
  <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
    Success message here
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <div id="error-alert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
    Error Alerts
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

</div>
<table class="table table-striped table-bordered">
<h3 class="page-heading" >Blood Requests</h3>
  <thead class="thead-dark">
    <tr>
      <th scope="col" class='text-center'><i class="fas fa-user"></i> Name</th>
      <th scope="col" class='text-center'><i class="fas fa-sort-numeric-up"></i>
        Units Available</th>
      <th scope="col" class='text-center'><i class="fas fa-tint"></i> Blood Group</th>
      <th scope="col" class='text-center'><i class="fas fa-birthday-cake"></i>
        Age</th>
      <th scope="col" class='text-center'><i class="fas fa-map-marker-alt"></i> Location</th>

      <th scope="col" class='text-center'><i class="fas fa-cog"></i>
        Action</th>
    </tr>
  </thead>
  <tbody>
    <?php

    use DataSource\DataSource;
    require_once __DIR__ . '../../../lib/DataSource.php';

    $con = new DataSource;
    $query = 'SELECT * from blood_donation where request_status= "pending"';
    $paramType = 's';
    $paramArray = array();
    $stocks = $con->select($query, $paramType, $paramArray);
    if (!empty($stocks)) {

      foreach ($stocks as $stock) {


        ?>
        <tr>
          <th scope="row" class='text-center'>
            <?php echo $stock['donor_name']; ?>
          </th>
          <td>
            <span class="table-icon"></span>
            <?php echo $stock['blood_group']; ?>
          </td>
          <td>
            <span class="table-icon"><i class="fas fa-tint"></i></span>
            <?php echo $stock['quantity']; ?>
          </td>
          <td>
            <span class="table-icon"></span>
            <?php echo $stock['age']; ?>

          </td>
          <td>
            <span class="table-icon"></span>
            <?php echo substr($stock['location'], 0, 20) . '....'; ?>
          </td>
          <td class='text-center'>
            <span class="table-icon text-success px-2"
              onclick="insertStock(<?php echo htmlspecialchars(json_encode($stock), ENT_QUOTES, 'UTF-8'); ?>,'<?php echo uniqid('stock-') ?>')"><i
                class="fas fa-check"></i></span>
           
            <span class="table-icon text-danger px-2" onclick="deleteDonor('<?php echo $stock['donation_id'] ?>')"><i
                class="fas fa-times"></i></span>


          </td>
        </tr>
        <?php
      }
    } else {
      echo "<strong class ='text-danger'>No requests</strong>";
    }
    ?>
  </tbody>
</table>
<script>
  let method, result;
  var successAlert = document.getElementById('success-alert');
    var errorAlert = document.getElementById('error-alert');
  const insertStock = async (data, stockID) => {
    Object.assign(data, {
      stock_id: stockID,
      method: ' accept',
      request_status: 'approved'
    });
    result = await postReq(data);
    successAlert.classList.remove('d-none');
    errorAlert.classList.add('d-none');
    setTimeout(function () {
      successAlert.classList.add('d-none');
      location.reload();
    }, 1300);

  }

  const deleteDonor = async (donorID) => {

    const data = {
      donation_id: donorID,
      method: 'reject'
    }
    result = await postReq(data); // wait for the Promise to resolve
    console.log(result);
    successAlert.classList.add('d-none');
    errorAlert.classList.remove('d-none');
    setTimeout(function () {
      errorAlert.classList.add('d-none');
      location.reload();
    }, 1300);

  }

  const postReq = async (data) => {
    // console.log(data)
    try {
      const response = await fetch('Model/handleDonationReq.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      });
      const responseData = await response.text(); // wait for the response data
      return responseData;
    } catch (error) {
      console.error('Error:', error);
      return error;
    }
  }
</script>