<?php
if (!defined('_VALID_ACCESS')) {
	header("location: index.php");
	die;
}

$akdb = new aksesdb;
$akdb->dbconnect(_DBSERVER, _DBUSER, _DBPASS, _DBNAME);

$profil = $akdb->dbobject("SELECT * FROM " . _TBPROFIL . " ORDER BY id_pf DESC LIMIT 0,1");
$tanggal = new tanggal;

$atas = 'mod/header.php';
if (file_exists($atas)) {
	include_once "$atas";
} else {
	echo "<center><div style=\"background-color: #eaeaea; margin-top: 80px; color:#313131; 
		border: #dadada 10px solid; width: 280px; 
		-moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px;
		font-size: 14px; font-weight:bold; text-shadow: 1px 1px #fff; padding: 10px;\">
		Sistem Gagal mengakses modul <b>HEADER</b></div></center>";
	die;
}

?>

<?php
$program = $akdb->dbquery("SELECT * FROM programtb");
$slider = $akdb->dbquery("SELECT * FROM utamatb WHERE status = '1'");

?>

<?php include 'mod/header.php' ?>


<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300" id="home-section">

	<?php include 'mod/menudkk.php' ?>

	<br>

	<!-- News -->
	<section class="site-section block-13" id="testimonials-section" data-aos="fade">
		<div class="container">

			<div class="row justify-content-center" data-aos="fade-up">
				<div class="col-lg-6 text-center heading-section mb-5">
					<h2 class="text-black mb-2">Tentang Kami</h2>
					<p>Berita Terkini Seputar Sumatera Barat</p>
				</div>
			</div>
			<div data-aos="fade-up" data-aos-delay="200">
				<!-- box detil -->
				<div class="row">
					<div class="col-md-8">
						<div class="card">
							<div class="card-body">
								<?php
								$sqlkonten = $akdb->dbobject("SELECT * FROM " . _TBKONTEN . " WHERE id_kt='1' AND konten='profil'");
								?>

								<div class="judul-konten"><?= $sqlkonten->judul; ?></div>

								<?php
								if ($sqlkonten->foto <> '') {
									echo "<div class=\"foto-konten\" align=\"center\">";
									echo "<img src=\"" . _URLWEB . "up/konten/" . $sqlkonten->foto . "\" class=\"img-fluid\" alt=\"\"/>";
									echo "</div>";
								}
								?>

								<div style="font-family: Arial, Helvetica, sans-serif !important;" id="isi-konten"><?= $sqlkonten->isi; ?></div>

								<div class="jarak3"></div>
								<div align="right"><a href="<?= _URLWEB; ?>" class="button"><span>Ke Beranda</span></a></div>

							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<?php
								$moki = 'mod/moki.php';
								if (file_exists($moki)) {
									include_once "$moki";
								} else {
									echo "";
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- box detil -->
			</div>
		</div>
	</section>
	<!-- News -->


	<?php
	include 'footer.php'
	?>