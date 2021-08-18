<?php 
	/* Copyright 2018 Atos SE and Worldline
	 * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */

	require 'survey.php'; 
	
	$survey = new Survey;
	
	// Create an array to represent the navbar buttons
	$navBar = array (
		// 'Cuestionario' => array ('Url' => 'section-' . SectionNameToURLName($survey->sections[0]['SectionName']), 'Type' => 'Standard'),
		// 'Sections' => array ('Type' => 'Dropdown' ),
		// 		// Sub-menus for each page are added here (see below)
		// 'Results' => array ('Url' => 'results', 'Type' => 'Standard' ),
		// 'Detailed Reports' => array ('Type' => 'Dropdown', 'Items' => array (
		// 		'Download CSV' => array('Url' => 'devops-maturity-csv.php', 'Type' => 'Standard'),
		// 		'Divider1' => array('Type' =>'Divider') ) ),
				// Sub-menus for detailed reports are added here, see below
		'Recursos' => array ('Url' => 'resources', 'Type' => 'Standard' ),
		'Acerca' => array ('Url' => 'about', 'Type' => 'Standard' ) );
	
	// Add the sub-menus for each page of the survey, and also for the detailed reports
	foreach ($survey->sections as $section)
	{
		$navBar['Sections']['Items'][$section['SectionName']]['Url'] = 'section-' . SectionNameToURLName($section['SectionName']);
		$navBar['Sections']['Items'][$section['SectionName']]['Type'] = 'Standard';
		if ( $section['HasSubCategories'] )
		{
			$navBar['Detailed Reports']['Items'][$section['SectionName']]['Url'] = 'results-' . SectionNameToURLName($section['SectionName']);
			$navBar['Detailed Reports']['Items'][$section['SectionName']]['Type'] = 'Standard';
		}
	}
	
	function GetBaseURL()
	{
		// Routine based on https://wp-mix.com/php-absolute-path-document-root-base-url/
		
		$doc_root = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']);
		//$doc_root = str_replace($doc_root, "\\", "\\");
		
		// base directory
		$base_dir = __DIR__;
		$base_dir = str_replace("\\", "/", $base_dir);
		
		// server protocol
		$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

		// domain name
		$domain = $_SERVER['SERVER_NAME'];

		// base url
		$base_url = str_replace($doc_root, '', $base_dir);
		
		// server port
		$port = $_SERVER['SERVER_PORT'];
		$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

		// put em all together to get the complete base URL
		return $protocol . "://" . $domain . $disp_port . $base_url;

	}
	
	function SectionNameToURLName($sectionName) {
		return strtolower(eliminar_tildes(str_replace(',', '', str_replace(' ', '-', $sectionName))));
	}
	function eliminar_tildes($cadena){

		//Codificamos la cadena en formato utf8 en caso de que nos de errores
		//$cadena = utf8_encode($cadena);
	
		//Ahora reemplazamos las letras
		$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
		);
	
		$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );
	
		$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );
	
		$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );
	
		$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );
	
		$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C'),
			$cadena
		);
		
		return $cadena;
	}
	
	function RenderNavBarButtons($navBar)
	{
		foreach ($navBar as $index=>$navBarButton)
		{
			switch ( $navBarButton['Type'] ) {
				case 'Standard':
					RenderStandardNavBarButton($index, $navBarButton['Url']);
					break;
				case 'Dropdown':
					RenderDropdownNavBarButton($index, $navBarButton);
					break;
			}
		}
	}
	
	function OnClickHandler($url)
	{
		global $isForm;
		if ( $isForm )
		{
			// If the page contains a form then we need to set the form action and submit
			return "$('form').attr('action', '$url'); $('form').submit();";
		}
		else
		{
			// If the page is not a form then just navigate to the right URL
			return "window.location = '$url';";
		}
	}
	
	function RenderStandardNavBarButton($buttonText, $url)
	{
		// Check if this is the button for the current page, and if so style it accordingly
		global $activePage;
		$active = '';
		if ($activePage == $buttonText)
		{
			$active = ' active';
		}
		?>
		<li>
			<a href="#" class="nav-link<?=$active?>" onclick="<?=OnClickHandler($url)?>"><?=$buttonText?></a>
		</li>
		<?php
	}
	
	function RenderDropdownNavBarButton($buttonText, $navBarButton)
	{
		// Check if this is the button for the current page, and if so style it accordingly
		global $activePage;
		$active = '';
		if ($activePage == $buttonText)
		{
			$active = ' active';
		}
		?>
		<li class="navbar-item dropdown">
			<a href="#" class="nav-link dropdown-toggle<?=$active?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?=$buttonText?>
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<?php foreach ($navBarButton['Items'] as $index=>$dropdownItem) { 
					switch ( $dropdownItem['Type'] ) {
						case 'Standard': ?>
							<a class="dropdown-item" href="#" onclick="<?=OnClickHandler($dropdownItem['Url'])?>"><?=$index?></a>
							<?php break;
						case 'Divider': ?>
							<div class="dropdown-divider"></div>
							<?php break;
					}
				}?>
			</div>
		</li>
		<?php
	}
	
?>

<!doctype html>
<html lang="en">
	<head>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
<script>
  window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#516573",
      "text": "#ffffff"
    },
    "button": {
      "background": "#96c11e",
      "text": "#ffffff"
    }
  },
  "position": "bottom-right",
  "content": {
    "href": "https://www.devopsgroup.com/privacy-policy/"
  }
 })});
</script>
    
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-38563910-6"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-38563910-6');
    </script>
		
		<!-- Required meta tags -->
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Open Graph info -->
		<meta property="og:title" content="Production Readiness Checklist" />
		<meta property="og:description" content="This online Production Readiness Checklist questionnaire will help you understand your current strengths and weaknesses and then recommend resources that can support you in taking the next steps on your Operations transition." />
		<meta property="og:site_name" content="Production Readiness Checklist" />
		<meta property="og:image" content="<?=GetBaseURL()?>/images/team-photos/og-image.jpg" />
		<meta property="og:image:width" content="1680" />
		<meta property="og:image:height" content="870" />
		
		<!-- Favicon stuff - check out https://realfavicongenerator.net/ -->
		<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<link rel="manifest" href="site.webmanifest">
		<link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#2d89ef">
		<meta name="theme-color" content="#ffffff">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="fontawesome/css/all.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.typekit.net/kuj3fcy.css">

		<title>Production Readiness Checklist</title>
		<script src="./js/chart.bundle.min.js"></script>
		<script src="js/jquery-3.3.1.min.js"></script>		
		
	</head>

	<nav class="navbar navbar-dark bg-secondary fixed-top navbar-expand-lg form-group">
		<a href="about" class="navbar-brand">Production Readiness Checklist</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<?php RenderNavBarButtons($navBar); ?>
			</ul>
		</div>
	</nav>	
	