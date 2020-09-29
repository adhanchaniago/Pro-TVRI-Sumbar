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
		border: #dadada 10px solid; width: 280px; font-family: Verdana, Arial, Helvetica, sans-serif; 
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

	<!-- Loading -->
	<div id="overlayer"></div>
	<div class="loader">
		<div class="spinner-border text-primary" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
	<!-- End Loading -->

	<div class="site-wrap">

		<!-- Mobile -->
		<div class="site-mobile-menu site-navbar-target">
			<div class="site-mobile-menu-header">
				<div class="site-mobile-menu-close mt-3">
					<span class="icon-close2 js-menu-toggle"></span>
				</div>
			</div>
			<div class="site-mobile-menu-body"></div>
		</div>
		<!-- End Mobile -->

		<div class="sticky-wrapper is-sticky">
			<header class="site-navbar js-sticky-header shrink site-navbar-target" role="banner">

				<div class="container">
					<div class="row align-items-center">

						<div class="col-6 col-xl-2">
							<h1 class="mb-0 site-logo"><a href="<?php echo _URLWEB; ?>home" class="h2 mb-0 text-white"><img class="img-fluid" style="max-width: 200%;" src="<?php echo _URLWEB; ?>cssMediatama/banner/logo.gif" alt="">
								</a></h1>
						</div>

						<div class="col-12 col-md-10 d-none d-xl-block">
							<nav class="site-navigation position-relative text-right" role="navigation">

								<ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
									<li class="dropdown nav-link">
										<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Program
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" style="color: #521b6c" href="<?php echo _URLWEB; ?>program/entertainment">Entertaiment</a>
											<a class="dropdown-item" style="color: #0e55a5" href="<?php echo _URLWEB; ?>program/news">News</a>
											<a class="dropdown-item" style="color: #05683a" href="<?php echo _URLWEB; ?>program/culture">Culture</a>
											<a class="dropdown-item" style="color: #d2571c" href="<?php echo _URLWEB; ?>program/kid">Kid</a>
											<a class="dropdown-item" style="color: #9e0b11" href="<?php echo _URLWEB; ?>program/sport">Sport</a>
											<a class="dropdown-item" style="color: #05683a" href="<?php echo _URLWEB; ?>program/life">Life</a>
										</div>
									</li>
									<li><a href="<?php echo _URLWEB; ?>home#jadwal" class="nav-link">Jadwal TV</a></li>
									<li><a href="<?php echo _URLWEB; ?>tentang" class="nav-link">Tentang Kami</a></li>
									<li><a href="stream" class="nav-link"><img style="width: 150px;" src="<?php echo _URLWEB; ?>cssMediatama/banner/live.gif" alt=""></a></li>
								</ul>
							</nav>
						</div>

						<div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a></div>

					</div>
				</div>

			</header>
		</div>


		<br>

		<section class="site-section" style="background-image: url('<?php echo _URLWEB; ?>cssMediatama/images/frame8.png">
			<div class="container">
				<div class="row justify-content-center" data-aos="fade-up">
					<div class="col-lg-6 text-center heading-section mb-5">
						<h2 class="text-black mb-2">Program Acara</h2>
						<?php
						if (strtolower($_GET['se']) == 'entertainment') {
							$warna = '521b6c';
							$text = 'Entertainment';
						} elseif (strtolower($_GET['se']) == 'kid') {
							$warna = 'd2571c';
							$text = 'Kid';
						} elseif (strtolower($_GET['se']) == 'news') {
							$warna = '0e55a5';
							$text = 'News';
						} elseif (strtolower($_GET['se']) == 'culture') {
							$warna = '05683a';
							$text = 'Culture';
						} elseif (strtolower($_GET['se']) == 'sport') {
							$warna = '9e0b11';
							$text = 'Sport';
						} elseif (strtolower($_GET['se']) == 'life') {
							$warna = '05683a';
							$text = 'Life';
						} else {
							$text = 'Detail Program Acara';
						}
						?>
						<p style="font-size: 15px; color: #<?= $warna ?>; font-weight: bold;"><?php echo $text ?></p>
					</div>
				</div>
				<div class="row">

					<?php
					if (isset($_GET["se"])) $se = $_GET['se'];
					else $se = "";
					if ($se == 'detil') {

						if (isset($_GET['id'])) {
							$id = $_GET['id'];
							$cekid = $akdb->dbobject("SELECT COUNT(*) as num FROM " . _TBPROGRAM . " WHERE id_pg='$id'");
							if ($cekid->num <= 0) {
								echo "Belum di Publikasikan";
							} else {

								$sqldetil = $akdb->dbobject("SELECT * FROM " . _TBPROGRAM . " WHERE id_pg ='$id' ORDER BY id_pg DESC LIMIT 1");
								$lasthit = $sqldetil->hit;
								$newhit = $lasthit + 1;
								$hitdbx = $akdb->dbquery("UPDATE " . _TBPROGRAM . " SET hit='$newhit' WHERE id_pg='$id' LIMIT 1");

								if ($sqldetil->foto <> '') {
									$imgdetil = "<div id=\"foto-detil\" align=\"center\"><img src=\"" . _URLWEB . "up/program/" . $sqldetil->foto . "\" class=\"img-fluid\" alt=\"$sqldetil->nama\"></div>";
								} else {
									$imgdetil = "";
								}

								$nama4 = str_replace(" ", "-", $sqldetil->nama);
								$nama41 = str_replace("/", "-", $nama4);
								$nama41 = str_replace("?", "-", $nama41);
					?>

								<!-- box detil -->
								<div class="row">
									<div class="col-md-8">
										<div class="card">
											<div class="card-body">
												<h2 class="text-black mb-2"><?= $sqldetil->nama; ?></h2>
												<p>
													<?= $sqldetil->jadwal ?>
												</p>
												<?php if ($sqldetil->subjudul <> '') {
													echo "<div class=\"judul-sub\">$sqldetil->subjudul</div>";
												} ?>

												<?= $imgdetil; ?>
												<br>
												<div style="float:left;width:75%;">
													<p class="ed-detil"> </p>
												</div>
												<div style="float:right; width:25%;" align="right">
													<a href="" class="increaseFont">A+</a><a href="" class="resetFont">AA</a><a href="" class="decreaseFont">A-</a>
												</div>
												<div class="clear">&nbsp;</div>

												<div class="isi-detil"><?php echo $sqldetil->isi; ?></div>

												<div class="card" style="float:left; width:50%;">
													<?php
													$bas = 'mod/bas.php';
													if (file_exists($bas)) {
														include_once "$bas";
													} else {
														echo "Belum di Publikasikan";
													}
													?>
												</div>
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
													echo "Belum di Publikasikan";
												}
												?>
											</div>
										</div>
									</div>
								</div>
								<!-- box detil -->

						<?php
							}
						}
					} elseif ($se == 'entertainment' or $se == 'news' or $se == 'culture' or $se == 'life' or $se == 'kid' or $se == 'sport') {

						?>

						<!-- box detil -->
						<?php
						$sqlse = $akdb->dbquery("SELECT * FROM " . _TBPROGRAM . " WHERE kat='" . ucwords($se) . "' ORDER BY id_pg DESC");

						while ($rowse = mysql_fetch_object($sqlse)) {

							$namase4 = str_replace(" ", "-", $rowse->nama);
							$namase41 = str_replace("/", "-", $namase4);
							$namase41 = str_replace("?", "-", $namase41);

							if ($rowse->foto <> '') {
								$imgse = _URLWEB . "up/program/" . $rowse->cfoto;
							} else {
								$imgse = _URLWEB . "img/thumb_no-img-program.jpg";
							}
						?>

							<!-- Awal Perulangan -->
							<div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="">
								<div class="card">
									<div class="card-body">
										<div class="d-lg-flex blog-entry">
											<figure class="mr-4">
												<a href="<?php echo _URLWEB . "program/detil/$rowse->id_pg/" . strtolower(str_replace(" ", "-", $namase41)) . ".html"; ?>"><img src="<?= $imgse; ?>" alt="Image" class="img-fluid"></a>
											</figure>
											<div class="blog-entry-text">
												<h3><a href="<?php echo _URLWEB . "program/detil/$rowse->id_pg/" . strtolower(str_replace(" ", "-", $namase41)) . ".html"; ?>"><?= substr($rowse->nama, 0, 45); ?></a></h3>

												<a href="<?php echo _URLWEB . "program/detil/$rowse->id_pg/" . strtolower(str_replace(" ", "-", $namase41)) . ".html"; ?>">
													<p class="text-black mb-3 d-block"><?= $rowse->jadwal ?></p>
												</a>
												<a href="<?php echo _URLWEB . "program/detil/$rowse->id_pg/" . strtolower(str_replace(" ", "-", $namase41)) . ".html"; ?>">
													<p><?= ($rowse->isi == '') ? 'Data tidak di temukan' : substr($rowse->isi, 0, 50) . '...' ?></p>
												</a>

												<p><a href="<?php echo _URLWEB . "program/detil/$rowse->id_pg/" . strtolower(str_replace(" ", "-", $namase41)) . ".html"; ?>" class="">Read More</a></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Akhir Perulangan -->

						<?php
						}
						?>

					<?php } ?>
				</div>

			</div>
	</div>
	</section>


	<?php
	include 'footer.php'
	?>