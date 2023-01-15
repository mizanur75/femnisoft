<section class="ftco-intro">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-3 color-1 p-4">
    				<h3 class="mb-4">Emergency Cases</h3>
    				<p>A small river named Duden flows by their place and supplies</p>
    				<span class="phone-number">+ (123) 456 7890</span>
    			</div>
    			<div class="col-md-3 color-2 p-4">
    				<h3 class="mb-4">Opening Hours</h3>
    				<p class="openinghours d-flex">
    					<span>Monday - Friday</span>
    					<span>8:00 - 19:00</span>
    				</p>
    				<p class="openinghours d-flex">
    					<span>Saturday</span>
    					<span>10:00 - 17:00</span>
    				</p>
    				<p class="openinghours d-flex">
    					<span>Sunday</span>
    					<span>10:00 - 16:00</span>
    				</p>
    			</div>
    			<div class="col-md-6 color-3 p-4">
    				<h3 class="mb-2">Make an Appointment</h3>
    				<form action="{{route('set_appoint')}}" method="POST" class="appointment-form">
                        @csrf
                        <div class="row">
                        	<div class="col-sm-5">
                            <div class="form-group">
            		              <div class="select-wrap">
                              <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                              <select name="doctor_id" id="" class="form-control" required>
                              	<option selected="false" disabled>Select Doctor</option>
                                <option value="1">Ashraful Haque</option>
                              </select>
                            </div>
            		            </div>
                          </div>
                          <div class="col-sm-7">
                            <div class="form-group">
                            	<div class="icon"><span class="icon-user"></span></div>
            		              <input type="text" class="form-control" name="appointment_name" id="appointment_name" placeholder="Name" required>
            		            </div>
                          </div>
                          <!-- <div class="col-sm-4">
                            <div class="form-group">
                            	<div class="icon"><span class="icon-paper-plane"></span></div>
            		              <input type="text" class="form-control" id="appointment_email" placeholder="Email">
            		            </div>
                          </div> -->
                        </div>
        	            <div class="row">
                        <div class="col-sm-4">
                          <div class="form-group">
                            <div class="icon"><span class="icon-phone2"></span></div>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                          </div>
                        </div>
        	              <div class="col-sm-4">
        	                <div class="form-group">
        	                	<div class="icon"><span class="ion-ios-calendar"></span></div>
        	                  <input type="text" name="appointment_date" class="form-control appointment_date" placeholder="Date" autocomplete="off" required>
        	                </div>    
        	              </div>
        	              <div class="col-sm-4">
        	                <div class="form-group">
        	                	<div class="icon"><span class="ion-ios-clock"></span></div>
        	                  <input type="text" name="appointment_time" class="form-control appointment_time" placeholder="Time" autocomplete="off" required>
        	                </div>
        	              </div>
        	            </div>
        	            
        	            <div class="form-group">
        	              <input type="submit" value="Make an Appointment" class="btn btn-primary">
        	            </div>
    	          </form>
    			</div>
    		</div>
    	</div>
    </section>