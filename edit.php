<?php

	// Check to make sure track_id is provided.
	if ( !isset($_GET['id']) || trim($_GET['id']) == '' ) {
		echo "Invalid URL";
		exit();
	} else {
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

		$mysqli->set_charset('utf8');


		// Genre:
		$sql_genres = "SELECT * FROM genre_table;";
		$results_genres = $mysqli->query($sql_genres);
		if ( $results_genres == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// Format:
		$sql_album_types = "SELECT * FROM album_type_table;";
		$results_album_types = $mysqli->query($sql_album_types);
		if ( $results_album_types == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$title_id = $_GET['id'];

		$sql = "SELECT * FROM playlist_table WHERE id = $title_id;";

		$result = $mysqli->query($sql);

		if (!$result) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$title = $result->fetch_assoc();

		// Close DB Connection
		$mysqli->close();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Edit song details in your FeelFlow.ai playlist. This page allows you to edit any entry you would like to update in the database and your playlist.">
	<title>Edit Form</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
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
			<h1 class="col-12 mt-4 mb-4">Edit a Song</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

			<div class="col-12 text-danger">
				<!-- Display Error Messages Here. -->
			</div>

			<form action="edit_confirmation.php" method="POST">

				<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

				<div class="form-group row">
					<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="title-id" name="title" value="<?php echo $title['title'] ?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="artist-id" class="col-sm-3 col-form-label text-sm-right">Artist: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="artist-id" name="artist" value="<?php echo $title['artist'] ?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
					<div class="col-sm-9">
						<select name="genre" id="genre-id" class="form-control">
							<option value="" selected disabled>-- Select One --</option>

							<?php while( $row = $results_genres->fetch_assoc() ): ?>

							<?php if ($row['genre_id'] == $title['genre_id']) :?>

								<option selected value="<?php echo $row['genre_id']; ?>">
									<?php echo $row['genre_name']; ?>
								</option>

							<?php else : ?>

								<option value="<?php echo $row['genre_id']; ?>">
									<?php echo $row['genre_name']; ?>
								</option>

							<?php endif; ?>

						<?php endwhile; ?>

						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="album-id" class="col-sm-3 col-form-label text-sm-right">Album: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="album-id" name="album" value="<?php echo $title['album'] ?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="album-type-id" class="col-sm-3 col-form-label text-sm-right">Album Type:</label>
					<div class="col-sm-9">
						<select name="album-type" id="album-type-id" class="form-control">
							<option value="" selected disabled>-- Select One --</option>

							<?php while( $row = $results_album_types->fetch_assoc() ): ?>

							<?php if ($row['album_type_id'] == $title['album_type_id']) :?>

								<option selected value="<?php echo $row['album_type_id']; ?>">
									<?php echo $row['album_type']; ?>
								</option>

							<?php else : ?>

								<option value="<?php echo $row['album_type_id']; ?>">
									<?php echo $row['album_type']; ?>
								</option>

							<?php endif; ?>

						<?php endwhile; ?>

						</select>
					</div>
				</div> <!-- .form-group -->

				

				<div class="form-group row">
					<div class="ml-auto col-sm-9">
						<span class="text-danger font-italic">* Required</span>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-2">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-light">Reset</button>
					</div>
				</div> <!-- .form-group -->

			</form>

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