<header id="header">
	<div class="container">
		<div id="navbar" class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>				
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="/" class="logo"></a></li>
                    <li><a href="/index.php#bestuur">Het Bestuur</a></li>
					<li><a href="/index.php#ereleden">Ereleden</a></li>
					<li><a href="/index.php#verenigingen">Verenigingen</a></li>
					<li><a href="/overzicht_teams.php">Teams</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Overzicht <b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/overzicht_wedstrijden.php">Wedstrijden</a></li>
							<li><a href="/overzicht_teamscore.php">Teamscores</a></li>
							<li><a href="/overzicht_persoonscore.php">Persoonsscores</a></li>
							<li><a href="/overzicht_persooninval.php">Inval</a></li>
						</ul>
					</li>
					<li><a href="/index.php#reglement">Reglement</a></li>
					<li><a href="/index.php#contact">Contact</a></li>
					<?php
                        if (!isset($_SESSION['loggedin'])) {
                            echo '<li><a href="/login/index.php">Login</a></li>';
                        }else{
                            echo '<li><a href="/admin/home.php">Beheer</a></li>';
                        }
                    ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="gap"></div>
</header>
