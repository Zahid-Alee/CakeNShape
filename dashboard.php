<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		/* Style the sidebar */
		.sidebar {
			height: 100%;
			width: 200px;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #1d1d1d;
			overflow-x: hidden;
			padding-top: 20px;
		}

		/* Style the sidebar links */
		.sidebar a {
			display: block;
			color: white;
			padding: 16px;
			text-decoration: none;
		}

		/* Change the color of the active/current link */
		.sidebar a.active {
			background-color: #4CAF50;
			color: white;
		}

		/* Style the sublink */
		.sublink {
			margin-left: 20px;
			color: white;
			padding: 8px;
		}
	</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
	<a href="#" class="active">Link 1</a>
	<a href="#">Link 2</a>
	<a href="#">Link 3</a>
	<a href="#">Link 4</a>
	<a href="#">Link 5 <span class="sublink">Sublink 1</span></a>
</div>

<!-- Page content -->
<div class="container-fluid" style="margin-left:200px">
	<h1>Welcome to the Admin Dashboard!</h1>
	<p>Please select a link from the sidebar to get started.</p>
</div>

</body>
</html>
