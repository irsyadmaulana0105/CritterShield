<?php 
session_start();
if($_SESSION['admin_username'] == ''){
    header("location:login.php");
    exit();
}
include("../inc/inc_koneksi.php");
include("../inc/inc_fungsi.php");
?>


<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Company Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <link href="../css/summernote-image-list.min.css">
    <script src="../js/summernote-image-list.min.js"></script>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HTML Template Simple Sidebar Menu → by InsertApps.com</title>
	<link rel="stylesheet" href="https://unpkg.com/ace-css/css/ace.min.css">
	<style>
		/*Additional Style */

		/* ######## START FOCUS CSS CODE HERE */
		#sidenav {
			max-height: 100vh;
			height: 100vh;
			max-width: 70vw;
			min-width: 300px;
			overflow-x: hidden;
			overflow-y: auto;
			transition: all .3s ease-in-out;
			transform: translate(-150%, 0px);
			-webkit-transform: translate(-150%, 0px);
			/* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
			-ms-transform: translate(-150%, 0px);
		}

		#sidenav.active {
			transition: all .3s ease-in-out;
			transform: translate(0%, 0px);
			-webkit-transform: translate(0%, 0px);
			-ms-transform: translate(0%, 0px);
			box-shadow: 0 4px 6px rgba(0, 0, 0, .4);
		}

		/* ######## END FOCUS CSS CODE HERE */

		.burger {
			height: 16px
		}
		.burger span {
			display: block;
			width: 20px;
			height: 2px;
			border-radius: 3px;
		}
		.pointer {
			cursor: pointer;
		}
		.close {
			width: 23px;
			height: 23px;
		}
		.cross {
			height: 23px;
			width: 2px;
			border-radius: 3px;
		}
		.cross.left {
			transform: rotate(45deg);
		}
		.cross.right {
			transform: rotate(-45deg);
		}
		.align-middle {
			vertical-align: middle
		}
	</style>
</head>
<body>
	<header class="bg-gray px2 py1 m0 flex items-center white">
		<div class="burger pointer flex flex-column justify-between mr2">
			<span class="bg-white"></span>
			<span class="bg-white"></span>
			<span class="bg-white"></span>
		</div>
		<nav class="ml-auto">
		<a class="white caps text-decoration-none h3 bold" href="logout.php">Logout</a>
		</nav>
		</nav>
		
	</header>
<!-- ######## START FOCUS SIDEBAR CODE HERE -->
	<div id="sidenav" class="fixed z4 top-0 left-0 bg-white p2">
		<div class="close flex items-center justify-center relative pointer mb2 right">
			<div class="absolute cross bg-gray left"></div>
			<div class="absolute cross bg-gray right"></div>
		</div>

		<div class="flex items-center justify-center white" style="width: 68px;height: 10px"></div>
		<p><a href="index.php" class="m0 muted bold">CritterShield</a></p>
		<!-- <p class="m0 muted bold">CritterShield</p> -->

		<hr>

		<ul class="list-reset muted m0">
			<li class="h6 caps mb2">ADMIN MASTER CONTENT</li>
			<li class="pointer mb2">
				<svg class="inline-block align-middle mr2" width="22" height="22" viewBox="0 0 16 16"
					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
					<path fill-rule="evenodd"
						d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
				</svg>
				<a class="black text-decoration-none align-middle" href="blogs.php">edukasi</a>
			</li>
			<li class="pointer mb2">
				<svg class="inline-block align-middle mr2" width="22" height="22" viewBox="0 0 16 16"
					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
					<path fill-rule="evenodd"
						d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
				</svg>
				<a class="black text-decoration-none align-middle" href="about.php">penyakit</a>
			</li>
			<!-- <li class="pointer mb2">
				<svg class="inline-block align-middle mr2" width="22" height="22" viewBox="0 0 16 16"
					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
					<path d="M5.5 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
					<path fill-rule="evenodd"
						d="M2.5 3.5a1 1 0 0 1 1-1c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1-1-1zm0 4a1 1 0 0 1 1-1 6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1-1-1z" />
				</svg>
				<a class="black text-decoration-none align-middle" href="info.php">Info</a>
			</li>
		</ul> -->

		<hr>

		<ul class="list-reset muted m0">
			<li class="h6 caps mb2"></li>
			<li class="pointer mb2">
				<svg class="inline-block align-middle mr2" width="22" height="22" viewBox="0 0 16 16"
					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M4 1h5v1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V6h1v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2z" />
					<path d="M9 4.5V1l5 5h-3.5A1.5 1.5 0 0 1 9 4.5z" />
					<path fill-rule="evenodd"
						d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
				</svg>
				<a class="black text-decoration-none align-middle" href="members.php">User</a>
			</li>
			<li class="pointer mb2">
				<svg class="inline-block align-middle mr2" width="22" height="22" viewBox="0 0 16 16"
					fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M4 1h5v1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V6h1v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2z" />
					<path d="M9 4.5V1l5 5h-3.5A1.5 1.5 0 0 1 9 4.5z" />
					<path fill-rule="evenodd"
						d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
				</svg>
				<a class="black text-decoration-none align-middle" href="ganti_profile.php">Ganti Password</a>
			</li>
		</ul>
	</div>
<!-- ######## END FOCUS SIDEBAR CODE HERE -->


	<!-- ######## START FOCUS JS CODE HERE -->
	<script>
		let burger = document.querySelector('.burger');
		let close = document.querySelector('.close');
		let sidenav = document.querySelector('#sidenav');

		// Burger click function
		burger.addEventListener('click', function () {
			sidenav.classList.add('active');
		});
		// Close click function
		close.addEventListener('click', function () {
			sidenav.classList.remove('active');
		});
	</script>
	<!-- ######## /END FOCUS JS CODE HERE -->
</body>
</html>