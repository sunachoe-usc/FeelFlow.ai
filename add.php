<?php 
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

	// Create SQL 
	$sql_genre = "SELECT * FROM genre_table;";

	// echo $sql;

	// Run SQL
	$results_genre = $mysqli->query($sql_genre);

	// Check for SQL Errors
	if ($results_genre == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Create SQL 
	$sql_album_type = "SELECT * FROM album_type_table;";

	// echo $sql;

	// Run SQL
	$results_album_type = $mysqli->query($sql_album_type);

	// Check for SQL Errors
	if ($results_album_type == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Create SQL 
	$sql_playlist = "SELECT * FROM playlist_table;";

	// echo $sql;

	// Run SQL
	$results_playlist = $mysqli->query($sql_playlist);

	// Check for SQL Errors
	if ($results_playlist == false) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}


	$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Contribute to your playlist by adding new songs. Fill out details about the song, artist, album, genre, and album type on this form.">

	<title>Add Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>

	<!-- <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="main.php">Home</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol> -->
	<div id="nav">
		<a href="FeelFlow_ai.php">Home</a>
		<a href="add.php">Add Song</a>
		<a href="playlist.php">My Playlist</a>
		<a href="random_song.html">Random Song!</a>
	</div> <!-- #nav -->


	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Add a song</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<form action="add_confirmation.php" method="POST">

			<div class="form-group row">
				<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="title-id" name="title">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="artist-id" class="col-sm-3 col-form-label text-sm-right">Artist: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="artist-id" name="artist">
				</div>
			</div> <!-- .form-group -->


			<div class="form-group row">
				<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
				<div class="col-sm-9">
					<select name="genre_id" id="genre-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>

						<!-- PHP Output Here -->
						<?php while ($row = $results_genre->fetch_assoc()) : ?>

								<option value='<?php echo $row["genre_id"]; ?>'>
									<?php echo $row["genre_name"]; ?>
								</option>

						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="album-id" class="col-sm-3 col-form-label text-sm-right">Album: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="album-id" name="album">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="album-type-id" class="col-sm-3 col-form-label text-sm-right">Album type:</label>
				<div class="col-sm-9">
					<select name="album_type_id" id="album-type-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>

						<!-- PHP Output Here -->
						<?php while ($row = $results_album_type->fetch_assoc()) : ?>

								<option value='<?php echo $row["album_type_id"]; ?>'>
									<?php echo $row["album_type"]; ?>
								</option>

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