<div style="min-width:380px">

  <div class="text-center" style="padding:15px"><h3 class="text-danger">Create Event</h3>
	<form action="create-event.php" method="POST">
		<div class='form-group'>
			<input class='form-control' type="text" name="event" placeholder="Enter Event Name" required >
		</div>
		<div class='form-group'>
			<input class='form-control' type="text" name="venue" placeholder="Enter Event Venue" required >
		</div>
		<div class='form-group'>
			<input class='form-control' type="date" name="date_fr" placeholder="Event Date Start" required >
		</div>
		<div class='form-group'>
			<input class='form-control' type="date" name="date_to" placeholder="Event Date End" required >
		</div>
		<div class='form-group'>
			<select name="service" class='form-control' required="required" >
			  <option value="" selected="1">Service</option>
			  <option value="Guests">Guests</option>
			  <option value="Served">Served</option>
			</select>
		</div>
		<div class='form-group' style="margin-bottom:0px">
			<input type='SUBMIT' name='submit' value='Submit' class="btn btn-danger text-white btn-user btn-block" >
		</div>
	</form>
  </div>
</div>