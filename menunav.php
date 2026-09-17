<?php
	$nav_events = array();
	$nav_query = $conn->query("SELECT * FROM events ORDER BY id");
	if ($nav_query) {
		while ($row = mysqli_fetch_array($nav_query)) {
			$nav_events[] = $row;
		}
	}
?>
<nav class="navbar navbar-expand-lg premium-nav sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" title="Home">
      <img src="images/logo.png" alt="Logo">
    </a>
    
    <button class="navbar-toggler btn-glass" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarNavDropdown" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="text-white" style="font-size: 1.2rem;">&#9776;</span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ml-auto" style="margin-left: auto;">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="eventsDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Events
          </a>
          <div class="dropdown-menu premium-dropdown" aria-labelledby="eventsDropdown">
            <?php foreach($nav_events as $rs) { ?>
              <a class="dropdown-item" href="events.php?events=<?php echo htmlspecialchars($rs[0]); ?>"><?php echo htmlspecialchars($rs["event"]); ?></a>
            <?php } ?>
          </div>
        </li>

        <?php if(isset($_SESSION['user'])){ ?>
        <li class="nav-item">
          <a class="nav-link" rel="facebox" href="create-event-form.php">Create Event</a>
        </li>
        <?php } ?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="codesDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            View Codes
          </a>
          <div class="dropdown-menu premium-dropdown" aria-labelledby="codesDropdown">
            <?php foreach($nav_events as $rs) { ?>
              <a class="dropdown-item" href="viewcodes.php?events=<?php echo htmlspecialchars($rs[0]); ?>"><?php echo htmlspecialchars($rs["event"]); ?></a>
            <?php } ?>
          </div>
        </li>

        <?php if(isset($_SESSION['user'])){ ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Settings
          </a>
          <div class="dropdown-menu premium-dropdown" aria-labelledby="settingsDropdown">
            <a class="dropdown-item" rel="facebox" href="user-profile.php">User Profile</a>
            <a class="dropdown-item" rel="facebox" href="server-config.php">Server Config</a>
          </div>
        </li>
        <?php } ?>

        <li class="nav-item">
          <?php if(!isset($_SESSION['user'])){ ?>
            <a class="nav-link" href="login.php">Login</a>
          <?php } else { ?>
            <a class="nav-link" href="logout.php">Logout</a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  $(document).ready(function(){
    // Manual fallback for dropdowns to ensure they always work
    $('.dropdown-toggle').on('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      var $menu = $(this).next('.dropdown-menu');
      $('.dropdown-menu').not($menu).hide(); // Close others
      $menu.toggle();
    });
    
    // Close dropdowns when clicking outside
    $(document).on('click', function(e){
      if(!$(e.target).closest('.dropdown').length) {
        $('.dropdown-menu').hide();
      }
    });
  });
</script>