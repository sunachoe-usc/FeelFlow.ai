<?php 
	if (!isset($_POST["title"]) || trim($_POST['title']) == '' || !isset($_POST["artist"]) || trim($_POST['artist']) == '' || !isset($_POST["album"]) || trim($_POST['album']) == ''){
		$error = "Please fill out the required fields";
	}
	else{
		// DB Credentials
		$host = "303.itpwebdev.com";
		$user = "sunachoe_db_user";
		$pass = "uscitp2023";
		$db = "sunachoe_feelflowai_db";

		// Connect DB
		$mysqli = new mysqli($host, $user, $pass, $db);

		// Check for MySQL Connection Errors
		if ($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');

		$title = $_POST["title"];
		$artist = $_POST["artist"];
		$album = $_POST["album"];

		if (isset($_POST['genre_id']) && trim($_POST['genre_id']) != '') {
			$genre_id = $_POST['genre_id'];
		} else {
			$genre_id = "null";
		}

		if (isset($_POST['album_type_id']) && trim($_POST['album_type_id']) != '') {
			$album_type_id = "'" . $_POST['album_type_id'] . "'";
		} else {
			$album_type_id = "null";
		}

		// DB Command
		$sql = "INSERT INTO playlist_table (artist, title, album, genre, album_type)
				VALUES ('$artist', '$title', '$album', $genre_id, $album_type_id);";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}


		$mysqli->close();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Confirmation page for adding a new song to the FeelFlow.ai playlist. View your song addition status and easily navigate to your personalized playlist.">
	<title>Add Confirmation</title>
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
			<h1 class="col-12 mt-4">Add Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if (isset($error) && !empty($error)) : ?>
					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>
				<?php else : ?>

					<div class="text-white"><span class="font-italic"><?php echo $title; ?></span> was successfully added.</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="playlist.php" role="button" class="btn btn-primary">Show Playlist</a>
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