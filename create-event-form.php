<div style="min-width:380px" class="premium-form">
  <div class="text-center" style="padding:15px">
    <h3 class="text-gradient mb-4">Create Event</h3>
    <form action="create-event.php" method="POST">
      <div class="form-group mb-3">
        <input class="form-control" type="text" name="event" placeholder="Event Name" required>
      </div>
      <div class="form-group mb-3">
        <input class="form-control" type="text" name="venue" placeholder="Event Venue" required>
      </div>
      <div class="form-group mb-3">
        <label class="text-muted-premium small text-left w-100 d-block mb-1">Start Date</label>
        <input class="form-control" type="date" name="date_fr" required>
      </div>
      <div class="form-group mb-3">
        <label class="text-muted-premium small text-left w-100 d-block mb-1">End Date</label>
        <input class="form-control" type="date" name="date_to" required>
      </div>
      <div class="form-group mb-4">
        <select name="service" class="form-control" required="required">
          <option value="" disabled selected>Select Service Type</option>
          <option value="Guests">Guests</option>
          <option value="Served">Served</option>
        </select>
      </div>
      <div class="form-group mb-0">
        <input type="submit" name="submit" value="Create Event" class="btn btn-premium w-100">
      </div>
    </form>
  </div>
</div>