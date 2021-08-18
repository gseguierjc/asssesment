<?php
	/* Copyright 2018 Atos SE and Worldline
	 * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */

	require 'survey.php'; 
	
	$survey = new Survey;

	// output headers so that the file is downloaded rather than displayed
	//header('Content-Type: text/csv; charset=utf-8');
	//header('Content-Disposition: attachment; filename=devops-maturity.csv');

	// create a file pointer connected to the output stream
	//$output = fopen('php://output', 'w');

	// output the column headings
	// fputcsv($output, array('Section', 'Sub Category', 'Question', 'Possible Answers', 'Max Score', 'Answer(s)', 'Score'));
	
	// Output questions (one row per question)
	foreach ($survey->sections as $section)
	{
		foreach ( $section['Questions'] as $question)
		{
			// Only export questions that have at least one possible answer
			if ( isset($question['Answers']) )
			{
				$subCategory = '';
				if ( isset($question['SubCategory']) )
				{
					$subCategory = $question['SubCategory'];
				}
				
				$answers = '';
				$possibleAnswers = '';
				switch ( $question['Type'] )
				{
					case 'Text':
						break;
					case 'Option':
						$possibleAnswers = "Choose one of:\n";
						break;
					case 'Checkbox':
						$possibleAnswers = "Choose all that apply:\n";
						break;
				}
				
				foreach ( $question['Answers'] as $answer )
				{
					$possibleAnswers .= $answer['Answer'] . ' (' . $answer['Score'] . ")\n"; // Show score for each answer in brackets
					if ( $answer['Value'] == 'checked' )
					{
					
						$answers .= $answer['Answer'] . "\n";
					}
				}
				// Remove trailing new lines
				$possibleAnswers = substr($possibleAnswers, 0, -1);
				$answers = substr($answers, 0, -1);
				// echo $answers;
				$row = array(	
								strtoupper($_SESSION['codeApp']),
								"",
								$section['SectionName'],
								$subCategory,
								$question['QuestionText'],
								$possibleAnswers,
								$survey->GetQuestionMaxScore($question),
								$answers,
								$survey->GetQuestionScore($question)
								);

								$servername = "surveysredatabase.mysql.database.azure.com";
								$username = "adminsre@surveysredatabase";
								$password = "Blameless#124";
								$dbname = "survey";
								// Create connection
								// Create connection
								$conn = new mysqli($servername, $username, $password, $dbname);
								// Check connection
								if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
								}
								
								$sql = "INSERT INTO assessment (codigoAplicacion,codigoRol,sectionName,question,possibleAnswers,maxScore,answer,score)
								VALUES ('{$row[0]}','{$row[1]}','{$row[2]}','{$row[4]}','{$row[5]}','{$row[6]}','{$row[7]}','{$row[8]}')";
								
								if ($conn->query($sql) === TRUE) {
								// echo "New record created successfully";
								} else {
								echo "Error: " . $sql . "<br>" . $conn->error;
								}
								
								$conn->close();				
				//fputcsv($output, $row);
			}
		}
	}
	header('Location: results');
?>