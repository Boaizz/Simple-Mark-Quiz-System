<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name ="description" content = "Quiz" />
	<meta name = "keywords"	 content = "Quiz,Search Engines" />
	<meta name = "author" content = "Three Jets" />
	<link rel="icon" href="images/logo.png">
	<title>Quiz</title>
		<link href= "styles/style.css" rel= "stylesheet"/>

</head>
<body>
	
<?php
        require ("menu.inc"); 
        ?>

<main>
<p id="quiztext">Test your new or current understandings of search engines in the quiz below!</p>
</main>
<form id="quiz" method="post" action="markquiz.php" novalidate>
	<fieldset>
		<Legend>Please enter your details</Legend>
		<p>
			<label for="firstname">First Name: </label><input type="text" name="firstname" id="firstname" maxlength="30" pattern="^[a-zA-Z]+$" />
			<label for="lastname">Family Name: <input type="text" name="lastname" id="lastname" maxlength="30" pattern="^[a-zA-Z]+$" ></label>
		</p>
		<p><label for="stu_id">Student Number: </label>
		<input type="text" name="stu_id" pattern="\d{7,10}" id="stu_id" /></p>
	</fieldset>
	<fieldset>
		<legend>Question 1</legend>
		<p class="questions"><label class="question">What is a search engine?</label></p>
			<label for="vehicle"><input type="radio" name="answer_1" id="vehicle" value="vehicle"/>A type of vehicle part</label>
            <label for="software"><input type="radio" name="answer_1" id="software" value="software" required="required"/>A software program used to search on the internet</label>
            <label for="crypto"><input type="radio" name="answer_1" id="crypto" value="crypto"/>A digital currency</label>
	</fieldset>
	<fieldset>
		<legend>Question 2</legend>
			<p class="questions"><label class="question">Which ones are an example of a search engine?</label></p>
			<label for="google"><input type="radio" id="google" name="answer_2" value="google"> Google</label>
			<label for="edge"><input type="radio" id="edge" name="answer_2" value="edge"> Microsoft Edge</label>
			<label for="word"><input type="radio" id="word" name="answer_2" value="word"> Microsoft Word</label>
			<label for="bing"><input type="radio" id="excel" name="answer_2" value="excel"> Microsoft Excel</label>
		<fieldset>
		<legend>Question 3</legend>
		<p class="questions"><label class="question">What was the first search engine?</label></p>
		<p><label for="answer_3"><input type="text" name="answer_3" id="answer_3" required="required" placeholder="Enter answer here..."/></label></p>
	</fieldset>
	<fieldset>
		<legend>Question 3</legend>
		<p class="questions"><label class="question">What is the most used search engine in 2020?</label></p>
		<p><label for="answer_4"><input type="text" name="answer_4" id="answer_4" required="required" placeholder="Enter answer here..."/></label></p>
	</fieldset>
	<fieldset>
		<legend>Question 5</legend>
			<p class="questions"><label class="question">Which would give the best result if searching for the car brand Jaguar?</label></p>
			<p><label for="q5"></label>
				<select name="answer_5" id="answer_5" required="required">
					<option value="" selected="selected">Please Select</option>
					<option value="car">&ldquo;Jaguar car&rdquo;</option>
					<option value="cat">Jaguar cat</option>
					<option value="jaguar">Jaguar</option>
				</select>
			</p>
	</fieldset>
	<p id="buttonanswer">
		<input type="submit" value="Submit Answers">
		<input type="reset" value="Reset Answers">
	</p>
</form>

</body>

</html>