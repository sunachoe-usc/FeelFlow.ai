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
	$mysqli->set_charset('utf8');


	// DB Command
	$sql = "SELECT playlist_table.id, playlist_table.title  AS title, 
				playlist_table.artist  AS artist, 
				playlist_table.album  AS album, 
				genre_table.genre_name AS genre, 
    			album_type_table.album_type AS album_type
			FROM playlist_table
			LEFT JOIN genre_table
				ON playlist_table.genre = genre_table.genre_id
			LEFT JOIN album_type_table
				ON playlist_table.album_type = album_type_table.album_type_id
			WHERE 1 = 1;";
	

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
	<meta name="description" content="Explore your personalized playlist on FeelFlow.ai. Browse through a curated collection of songs, manage your favorite tracks, and customize your playlist by adding, deleting, or editing song details.">
	<title>My Playlist</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style>
	h1{
		font-family: Ubuntu, sans-serif; 
		color: white;
		text-align: center;
	}

	p{
		font-family: Ubuntu, sans-serif; 
		color: white;
	}
</style>
<body>
	<div id="nav">
		<a href="FeelFlow_ai.php">Home</a>
		<a href="add.php">Add Song</a>
		<a href="playlist.php">My Playlist</a>
		<a href="random_song.html">Random Song!</a>
	</div> <!-- #nav -->

	<h1>
		My Playlist
	</h1>

	<div class="container">
	
		<div class="row">
			<div class="col-12">

				Showing <?php echo $results->num_rows; ?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th>Song Title</th>
							<th>Artist</th>
							<th>Album</th>
							<th>Album Type</th>
							<th>Genre</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = $results->fetch_assoc()) : ?>

							<tr>
								<td>
									<a href="delete.php?id=<?php echo $row['id'] ?>&title=<?php echo $row['title'] ?>" 
										class="btn btn-outline-light"
										onclick="return confirm('Are you sure you want to delete this song?')"
										>
										Delete
									</a>
								</td>
								<td>
									<a href="edit.php?id=<?php echo $row['id'] ?>&title=<?php echo $row['title'] ?>" 
										class="btn btn-outline-light"
										>
										Edit
									</a>
								</td>
								<td>
									<?php echo $row["title"]; ?>
								</td>
								<td>
									<?php echo $row["artist"]; ?>
								</td>
								<td>
									<?php echo $row["album"]; ?>
								</td>
								<td>
									<?php echo $row["album_type"] ?> 
								</td>
								<td>
									<?php echo $row["genre"] ?> 
								</td>
							</tr>

						<?php endwhile; ?>
					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			
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
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
	
</body>
</html>