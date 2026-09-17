<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Event Guest Counter">
    <title>Event Guest Counter</title>
    <link rel="shortcut icon" href="images/favicon.png" />
    
    <!-- Bootstrap & Premium Theme -->
	<link href="assets/sweetalert2/dist/sweetalert2.all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/premium.css" media="screen">
    
    <!-- jQuery, SweetAlert2, FontAwesome, ChartJS, Bootstrap JS -->
    <script src="assets/jquery/jquery.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet">
    <script src="assets/chartjs/chart.js"></script>
</head>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    // Hijack legacy facebox links to use SweetAlert2 instead
    $('a[rel*=facebox]').on('click', function(e) {
      e.preventDefault();
      var targetUrl = $(this).attr('href');
      
      Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      $.get(targetUrl, function(data) {
        Swal.fire({
          html: data,
          width: '600px', // Matches Bootstrap modal width
          showConfirmButton: false,
          showCloseButton: true,
          background: 'var(--bg-color)',
          color: 'var(--text-main)',
          customClass: {
            popup: 'premium-swal-popup',
            closeButton: 'premium-swal-close'
          }
        });
      }).fail(function() {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong while loading the content!',
          background: 'var(--bg-color)',
          color: 'var(--text-main)'
        });
      });
    });
  });
</script>

<body>