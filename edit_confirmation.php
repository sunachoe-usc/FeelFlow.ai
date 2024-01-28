<?php
	// Check to see if any required fields are missing.

	if ( !isset($_POST['title']) || trim($_POST['title']) == '') {
		// One or more of the required fields is empty.
		$error = "Please fill out all required fields.";
	} else {
		// All required fields provided. Continue with the ADD workflow.
		// DB Credentials
		$host = "303.itpwebdev.com";
		$user = "sunachoe_db_user";
		$pass = "uscitp2023";
		$db = "sunachoe_feelflowai_db";

		// DB Connection.
		$mysqli = new mysqli($host, $user, $pass, $db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		$title_id = $_POST['id'];
		$title = $_POST['title'];
		$artist = $_POST['artist'];
		$album = $_POST['album'];


		if ( isset($_POST['genre_id']) && trim($_POST['genre_id']) != '' ) {
			$genre_id = $_POST['genre_id'];
		} else {
			$genre_id = "null";
		}

		if ( isset($_POST['album_type_id']) && trim($_POST['album_type_id']) != '' ) {
			$album_type_id = $_POST['album_type_id'];
		} else {
			$album_type_id = "null";
		}

		$sql = "UPDATE playlist_table
				SET title = '$title',
					artist = '$artist',
					album = '$album',
					genre = $genre_id,
					album_type = $album_type_id
				WHERE id = $title_id;";


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
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Confirm the successful update of a song in your FeelFlow.ai playlist. This page notifies users about the successful modification of song details, ensuring your playlist remains up-to-date.">
	<title>Edit Confirmation</title>
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
			<h1 class="col-12 mt-4">Edit a Song</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<!-- <div class="text-danger font-italic">Display Error Messages Here</div>

				<div class="text-success"><span class="font-italic">Title</span> was successfully edited.</div> -->

				<?php if ( isset($error) && trim($error) != '' ) : ?>

					<div class="text-danger">
						<?php echo $error; ?>
					</div>

				<?php else: ?>

					<div class="text-white">
						<span class="font-italic"><?php echo $title; ?></span> was successfully edited.
					</div>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				
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