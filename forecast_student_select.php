<?php
	include 'header.php';
	echo"
		<link href='/brockportforecasting/css/cardStyles.css' type='text/css' rel='stylesheet' />
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
	";


		require('db_cn.inc');
		connect_and_select_db(DB_SERVER, DB_UN,DB_PWD,DB_NAME);

		//Connect to the DB
		function connect_and_select_db($server, $username, $pwd, $dbname)
		{
			$conn = mysql_connect($server, $username, $pwd);

			if (!$conn)
			{
				echo "Unable to connect to DB:".mysql_error();
				exit;
			}

			$dbh = mysql_select_db($dbname);
			if(!$dbh)
			{
				echo "Unable to select".$dbname.":".mysql_error();
				exit;
			}
		}
?>

<?php
	if ((isset($_SESSION['id'])) && ((string)$_SESSION['access'] == 'admin'))
	{
		echo "
			<center><h2>Select a student to view their forecasts</h2>
			<form action='forecast_student_select_process.php' method='post'>
			<select id='student' name='student'>";
				$sql = "SELECT * FROM `user` WHERE status='Active' AND access='student' ORDER BY 'first' ASC;";
				$result = mysql_query($sql);
				if (!$result)
				{
					$message = "Error! Unable to get students from the Database: ".mysql_error();
					echo "<SCRIPT LANGUAGE='JavaScript'>
						 window.alert('$message')
						 window.location.href='index.php';
						 </SCRIPT>";
					exit;
				}
				while ($row = mysql_fetch_assoc($result))
				{
					$firstname = $row['first'];
					$lastname = $row['last'];
					$uid = $row['uid'];

					$option = $firstname.', '.$lastname;

					echo "<option value='$uid'>".$option."</option>";
				}
				echo "<br><br>
				<p align='center'>
						<input type='submit' value='View Selected Student's Forecasts'/><br
				</p>
			</form>
			</center>
		";
	}
	else
	{
		//echo '<script type='text/javascript'>alert('Please login to view this page')</script>';
		session_destroy();
		echo "<SCRIPT LANGUAGE='JavaScript'>
			 window.alert('Please Login as an Admin to View This Page')
			 window.location.href='index.php';
			 </SCRIPT>";
	}
echo "
</body>
</html>
"
?>
