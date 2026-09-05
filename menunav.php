<?php
	$nav_events = array();
	$nav_query = $conn->query("SELECT * FROM events ORDER BY id");
	if ($nav_query) {
		while ($row = mysqli_fetch_array($nav_query)) {
			$nav_events[] = $row;
		}
	}
?>
<header class="u-clearfix u-header" id="sec-621b">
	<div class="u-clearfix u-sheet u-valign-middle u-sheet-1">

		<a href="index.php" class="hid u-image u-logo u-image-1" data-image-width="1600" data-image-height="366" title="Home">
          <img src="images/logo.png" class="u-logo-image u-logo-image-1">
        </a>
		
        <nav class="hid u-menu u-menu-dropdown u-offcanvas u-menu-1">
          <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px;">
            <a class="u-button-style u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="#">
              <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#menu-hamburger"></use></svg>
              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><symbol id="menu-hamburger" viewBox="0 0 16 16" style="width: 16px; height: 16px;"><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect></symbol></defs></svg>
            </a>
          </div>
          <div class="u-custom-menu u-nav-container">
            <ul class="u-nav u-unstyled u-nav-1">
				<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="index.php" style="padding: 16px 10px;">Home</a></li>
				<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">Events</a>
					<div class="u-nav-popup">
						<ul class="u-h-spacing-20 u-nav u-unstyled u-v-spacing-10 u-nav-2">
						<?php 	
							foreach($nav_events as $rs){	
							echo"<li class='u-nav-item'><a href='events.php?events=$rs[0]' class='u-button-style u-nav-link u-white'>".$rs["event"]."</a></li>";
							}
						?>
						</ul>
					</div>
				</li>
				<?php if(isset($_SESSION['user'])){ ?>
				<li class="u-nav-item"><a rel="facebox" href="create-event-form.php" class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">Create Event</a></li>
				<?php } ?>
				<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">View Codes</a>
					<div class="u-nav-popup">
						<ul class="u-h-spacing-20 u-nav u-unstyled u-v-spacing-10 u-nav-2">
						<?php 	
							foreach($nav_events as $rs){	
								echo"<li class='u-nav-item'><a href='viewcodes.php?events=$rs[0]' class='u-button-style u-nav-link u-white'>".$rs["event"]."</a></li>";
							}
						?>
						</ul>
					</div>				
				</li>	
				<?php if(isset($_SESSION['user'])){ ?>
				<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">Settings</a>
					<div class="u-nav-popup">
						<ul class="u-h-spacing-20 u-nav u-unstyled u-v-spacing-10 u-nav-2">
							<li class='u-nav-item'><a rel="facebox" href='user-profile.php' class='u-button-style u-nav-link u-white'>User Profile</a></li>
							<li class='u-nav-item'><a rel="facebox" href='server-config.php' class='u-button-style u-nav-link u-white'>Server Config</a></li>
						</ul>
					</div>				
				</li>	
				<?php } ?>
				<li class="u-nav-item">
					<?php if(!isset($_SESSION['user'])){ ?>
						<a href="login.php" class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">
							Login
						</a>
					<?php } else { ?>
						<a href="logout.php" class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">
							Logout
						</a>	
					<?php } ?>
				</li>
			</ul>
          </div>
          <div class="u-custom-menu u-nav-container-collapse">
            <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
              <div class="u-inner-container-layout u-sidenav-overflow">
                <div class="u-menu-close"></div>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-3">
					<li class="u-nav-item"><a class="u-button-style u-nav-link" href="index.php" style="padding: 16px 10px;">Home</a></li>
					<li class="u-nav-item"><a class="u-button-style u-nav-link" style="padding: 16px 10px;">Events</a>
						<div class="u-nav-popup">
							<ul class="u-h-spacing-20 u-nav u-unstyled u-v-spacing-10 u-nav-4">
							<?php 	
								foreach($nav_events as $rs){	
									echo"<li class='u-nav-item'><a href='events.php?events=$rs[0]' class='u-button-style u-nav-link'>".$rs["event"]."</a></li>";
								}
							?>
							</ul>
						</div>
					</li>
					<?php if(isset($_SESSION['user'])){ ?>
					<li class="u-nav-item"><a class="u-button-style u-nav-link" data-toggle="modal" data-target="#myModal1" style="padding: 16px 10px;">Create Event</a></li>
					<?php } ?>
					<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">View Codes</a>
						<div class="u-nav-popup">
							<ul class="u-h-spacing-20 u-nav u-unstyled u-v-spacing-10 u-nav-2">
							<?php 	
								foreach($nav_events as $rs){	
								echo"<li class='u-nav-item'><a href='viewcodes.php?events=$rs[0]' class='u-button-style u-nav-link'>".$rs["event"]."</a></li>";
								}
							?>
							</ul>
						</div>				
					</li>
					<?php if(isset($_SESSION['user'])){ ?>
					<li class="u-nav-item"><a class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">Settings</a>
						<div class="u-nav-popup">
							<ul class="u-h-spacing-20 u-nav u-unstyled u-v-spacing-10 u-nav-2">
								<li class='u-nav-item'><a rel="facebox" href='user-profile.php' class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base">User Profile</a></li>
								<li class='u-nav-item'><a rel="facebox" href='server-config.php' class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base">Server Config</a></li>
							</ul>
						</div>				
					</li>	
					<?php } ?>					
					<li class="u-nav-item">
						<?php if(!isset($_SESSION['user'])){ ?>
							<a href="login.php" class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">
								Login
							</a>
						<?php } else { ?>
							<a href="logout.php" class="u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" style="padding: 16px 10px;">
								Logout
							</a>	
						<?php } ?>
					</li>
				</ul>
              </div>
            </div>
            <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
          </div>
        </nav>
	</div>
</header>