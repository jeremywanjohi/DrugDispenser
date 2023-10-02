<html>
<head>
	<title><?php echo $pageTitle;?></title>
	<link rel="stylesheet" href="styles2.2.css" type="text/css">
</head>
<body>

	<div class="header">

		<div class="wrapper">

			<h1 class="category-title"><a href="./">View Page</a></h1>

			<ul class="nav">
                <li class="antibiotics <?php if($section=="antibiotics"){ echo "on";}?>"><a href="view_details.php?cat=antibiotics">Antibiotics</a></li>
                <li class="painkillers <?php if($section=="painkillers"){ echo "on";}?>"><a href="view_details.php?cat=painkillers">Painkillers</a></li>
                <li class="anti-inflammants <?php if($section=="anti-inflammants"){ echo "on";}?>"><a href="view_details.php?cat=music">Music</a></li>
                
            </ul>

		</div>

	</div>

	<div id="content">