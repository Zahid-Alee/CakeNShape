<div class="card-body">
  <form id="requestBlood" method="post">
    <input type="text" name="request_id" value="<?php echo uniqid('request-') ?>" hidden>
    <div class="form-group">
      <label for="donorName"><i class="fas fa-user"></i> Hospital Name</label>
      <input type="text" class="form-control" name="hospital_name" placeholder="Enter your name">
    </div>
    <div class="form-group">
      <label for="bloodType"><i class="fas fa-notes-medical"></i> Blood Type</label>
      <select class="form-control" name="blood_group">
        <option value="" disabled selected>Select blood type</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
      </select>
    </div>
    <div class="form-group">
      <label for="donorAge"><i class="fas fa-male"></i> Quantity</label>
      <input type="number" class="form-control" name="quantity"  min='1' placeholder="Enter your age">
    </div>
    <div class="form-group">
      <label for="donorAge"><i class="fas fa-male"></i>Contact</label>
      <input type="number" class="form-control" name="contact_no" placeholder="Enter your age">
    </div>
    <div class="form-group">
      <label for="donorAge"><i class="fas fa-male"></i> location</label>
      <input type="text" class="form-control" name="location" placeholder="Enter your age">
    </div>
    <button type="submit" id="submit-btn" class="btn btn-danger closeModalBtn2 "><i class="fas fa-paper-plane"></i> Submit</button>
  </form>
</div>

<script>
  const reqForm = document.getElementById('requestBlood');
  reqForm.addEventListener('submit', submitBloodDonationForm);

  function submitBloodDonationForm(event) {
    event.preventDefault();
    const formValues = new FormData(event.target);


    fetch('http://localhost/BBM/Model/makeRequest.php', {
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