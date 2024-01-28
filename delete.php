<?php
	
	// Valid URL w/ track_id.

	// DB Credentials
	$host = "303.itpwebdev.com";
	$user = "sunachoe_db_user";
	$pass = "uscitp2023";
	$db = "sunachoe_feelflowai_db";

	// Establish MySQL Connection.
	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check for any Connection Errors.
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$id = $_GET['id'];

	$sql = "DELETE FROM playlist_table WHERE id = $id;";

	// echo "<hr>$sql<hr>";

	$results = $mysqli->query($sql);

	if (!$results) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$mysqli->close();
	

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Remove songs from your FeelFlow.ai playlist. This page allows for the easy deletion of songs, helping you keep your playlist fresh and relevant to your current music preferences.">
	<title>Delete a Song</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div id="nav">
		<a href="FeelFlow_ai.php">Home</a>
		<a href="add.php">Add Song</a>
		<a href="playlist.php">My Playlist</a>
		<a href="random_song.html">Random Song!</a>
	</div> <!-- #nav -->
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Delete a Song</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if( isset($error) && trim($error) != '' ): ?>

					<div class="text-danger">
						<!-- Display Error Messages Here. -->
						<?php echo $error; ?>
					</div>

				<?php else: ?>

					<div class="text-white"><span class="font-italic"><?php echo $_GET['title'] ?></span> was successfully deleted.</div>

				<?php endif; ?>
				
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="playlist.php" role="button" class="btn btn-primary">Back to Playlist</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
	<script> 

		document.querySelector("body")
		let h = 0
		let l = 0
		const colorChangeInterval = setInterval(() => {
    		document.body.style.backgroundColor = `hsl(${h}, 80%, 50%)`;
    		h++
    		l+=2
    		if (h === 360) {
      			h = 0
    		}
    		if (l === 100) {
    			l = 0
    		}
    		// console.log(h);
  		}, 50); // Change the color every 1000 milliseconds (1 second)

		
	</script>
</body>
</html>