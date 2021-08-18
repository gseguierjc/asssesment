<?php 
	/* Copyright 2018 Atos SE and Worldline
	 * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */
	

	
	require 'header.php';
   
   $isForm = FALSE;
   $activePage = 'About';

	function RenderTwitterLink($URL)
	{
		?>
		<a style="color:#00A3F3" href="<?=$URL?>" target="_blank">
			<span class="fa-stack fa-1x">
				<i class="fas fa-square fa-stack-2x"></i>
				<i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
			</span>
		</a>
		<?php
	}
	
	function RenderLinkedInLink($URL)
	{
		?>
		<a style="color:#0078B5" href="<?=$URL?>" target="_blank">
			<span class="fa-stack fa-1x">
				<i class="fas fa-square fa-stack-2x"></i>
				<i class="fab fa-linkedin-in fa-stack-1x fa-inverse"></i>
			</span>
		</a>  
		<?php
	}
	
?>
<!-- Header - Improve your Prodcution Readiness  -->
	<header class="container-fluid">
		<div class="row text-center">
			<div class="col-12">
				<h1>Mejora constantemente</h1>
				<p class="lead pb-4">Este cuestionario le ayudará a comprender sus puntos fuertes y débiles actuales con respecto a una cultura resiliente. Le recomendará recursos que pueden ayudarle a dar los siguientes pasos en su viaje de mejora a una cultura resiliente.</p>
				<a href="<?='section-' . SectionNameToURLName($survey->sections[0]['SectionName'])?>" class="btn btn-primary mr-0 mr-sm-2">Comenzar el cuestionario</a>
				<!-- <a href="https://github.com/devopsguys/production-readiness-review" target="_blank" class="btn btn-outline-light mt-3 mt-sm-0">Fork us on GitHub</a> -->
			</div>
		</div>
	</header>

	<div class="container">
<!-- Three columns of text below the header  -->
		<div class="row mb-5">
			<div class="col-12">
				<div class="card-deck text-left text-lg-center header-overlap">
					<!--Understand where you are-->
					<div class="card shadow py-2 px-2 mb-lg-0">
						<div class="card-header d-flex text-left align-items-center shadow rounded">
							<i class="fas fa-question fa-3x mr-3 text-primary"></i>
							<h5 class="card-title">Entender dónde estamos</h5>
						</div>
						<div class="card-body">
							<p class="card-text">Nuestro conjunto de preguntas cuidadosamente diseñadas en 6 áreas diferentes le ayudarán a establecer rápidamente su nivel actual..</p>
							<p class="card-text">Puede ver los resultados en línea al finalizar el cuestionario.</p>
						</div>
					</div>
					<!--Identify next steps-->
					<div class="card shadow py-2 px-2 mt-5 mt-lg-0 mb-lg-0">
						<div class="card-header d-flex text-left align-items-center shadow rounded">
							<i class="fas fa-arrow-right fa-3x mr-3 text-primary"></i>
							<h5 class="card-title">Identificar siguientes pasos.</h5>
						</div>
						<div class="card-body">
							<p class="card-text">Para cada área hemos identificado una serie de libros, vídeos, blogs, libros blancos y sitios web gratuitos o disponibles en el mercado que le ayudarán a dar los siguientes pasos orientado a una cultura resiliente..</p>
						</div>
					</div>
					<!--Free and open source-->
					<!-- <div class="card shadow py-2 px-2 mt-5 mt-lg-0 mb-lg-0">
						<div class="card-header d-flex text-left align-items-center shadow rounded">
							<i class="fas fa-code-branch fa-3x mr-3 text-primary"></i>
							<h5 class="card-title">Free and Open Source</h5>
						</div>
						<div class="card-body">
							<p class="card-text">This tool is made available under the MIT License: you are free to use, adapt and redistribute it, both for commercial and non-commercial use. There is no obligation to share your changes, although we always appreciate feedback!</p>
							<a href="https://github.com/devopsguys/production-readiness-review" class="card-link">Why not fork us on GitHub?</a>
						</div>
					</div> -->
				</div>
			</div>
		</div>
		<div class="row text-center mb-5">
			<div class="col-12">
				<p class="small">We do not harvest your data and we will not share your results with anyone else.</p>
			</div>
		</div>
</div>

		<!-- TEST LINE--> 
    <!-- TEST LINE AGAIN--> 

		

</div>
</div><!-- /.container -->
<?php
	
	require 'footer.php';
	
?>		

	