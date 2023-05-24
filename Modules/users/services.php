<style>
    
.services {
  /* position: relative; */
  /* top: 290px; */
  width: 70%;
  background-color: aliceblue;
  border-color: 2px solid black;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: auto;
  /* margin-top: 330px; */
}

.services .service {
  width: 50%;
  padding: 15px;
  /* border: 1px solid grey; */
  display: flex;
  flex-flow: column;
  align-items: center;
  justify-content: center;
  border: 1px solid #c3c3c3;
  background-color: #fff2f28c;

}

.services h2 {

  font-size: 22px;
  font-weight: 600;
  padding: 10px;
  color: #a71947;
}

.services p {
  font-size: 16px;
  font-weight: 500;
  color: rgb(0, 0, 0, 74%);
}

.services .icon {

  font-size: 28px;
  color: #a71947;
}


.categories {}

.categories h2 {
  font-size: 30px;
  font-weight: 700;
  /* margin: 50px 0px; */
  padding: 0px 50px;
  text-align: center;
}

.category-container {
  /* margin: 50px 10px; */
  width: 90%;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  gap: 1%;
  align-items: center;
  justify-content: center;
  margin: auto;

}

.category {
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05),
    0 1px 3px 1px rgba(0, 0, 0, 0.08);
  border: 1px solid #d9d9d9;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  padding: 3px 10px;
  /* max-width: 300px; */

}

.category .tag {


  font-size: 25px;
  color: #059100;
  /* position: relative; */
  align-self: flex-start;
  /* left: 0; */
  /* top: -10px; */
}

.details {
  margin-top: 50px;
  text-align: center;
}

.details h3 {

  font-size: 20px;
  font-weight: 600;
  color: #761f3c;
  padding: 10px;
}

.details .items {

  /* color: #06b300; */
  border-radius: 2px;
  font-weight: 700;

}

.category .img {
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;

}

.category img {
  width: 200px;
  align-self: flex-end;
  /* height: 200px; */
}


</style>
<section id="services" class=" py-4">

    <div class="services">
        <div class="service">
            <span class="clock icon"><i class="bx bx-cart"></i></span>
            <h2>Fast Shipping</h2>
            <p class="description">On Every Product</p>
        </div>
        <div class="service">
            <span class="clock icon"><i class="bx bx-time"></i></span>
            <h2>Delivery on time</h2>
            <p class="description">3 to 4 working days</p>
        </div>
        <div class="service">
            <span class="dollar icon"><i class="bx bx-dollar-circle"></i></span>
            <h2>Secure Payment</h2>
            <p class="description">100% secure payment</p>
        </div>
    </div>
</section>