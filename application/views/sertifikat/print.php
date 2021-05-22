<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sertifikat</title>
	<link rel="stylesheet" href="<?php echo base_url('vendors'); ?>/bundle.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/app.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url('fonts'); ?>/oranda/oranda-font.css" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/print-sertifikat.css'); ?>">
</head>

<body class="page-sertifikat">
	<div class="square">
		<div class="logo">
			<img class="img-fluid" width="75" height="75" src="<?php echo base_url('assets/media/image/dmtekno.png'); ?>" alt="dmtekno-logo">
			<img class="img-fluid" width="75" height="75" src="<?php echo base_url('assets/media/image/umbrella-logo.png'); ?>" alt="umbrella-logo">
		</div>

		<h1 class="tittle">CERTIFICATE</h1>
		<div class="subtittle">
			<h1>OF APPRECIATION</h1>
		</div>
		<h5 class="subtittle1 mt-4">
			This Certificate presented to:
		</h5>
		<div class="nama">
			<h2><?php echo $sertifikat['magang_user'];?></h2>
		</div>
		<div class="deskripsi">
			<p class="mb-0">for successfully completed skills competence training as:</p>
			<div>
				<div class="text-dark h4 font-weight-700 mb-0"><?php echo $sertifikat['division_name']?></div>
				<p class="text-dark h5 font-weight-600"><?php echo $sertifikat['sertifikat_code']?></p>
			</div>
			<div>
				<p>according to the terms and conditions of competence <br>in Partnership with</p>
			</div>

		</div>
		<div class="mt-3 w-100 row justify-content-end">
			<div class="col-4">
				<img class="img-fluid mx-auto" width="75" height="75" src="<?php echo base_url('assets/media/image/logo/'.$sertifikat['partner_img'].''); ?>">
			</div>
			<div class="col-4">
				<div class="box">
					<span>
						Hery Purwanto
					</span>
				</div>
			</div>

		</div>

		<div class="copyright">
			<div class="text-muted">dmtekno.com</div>
			<div class="text-muted">umbrella.co.id</div>
		</div>
		<div class="qrcode">
			<img class="img-fluid" src="<?php echo base_url('assets/media/image/qrimg/'.$sertifikat['sertifikat_qr'].''); ?>" width="75" height="75">
		</div>
	</div>

	<script src="<?php echo base_url('vendors'); ?>/bundle.js"></script>
</body>

</html>