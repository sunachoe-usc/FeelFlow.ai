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

	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="description" content="FeelFlow.ai offers personalized music recommendations based on your mood. Simply describe how you're feeling and get a custom playlist suited to your current emotions.">
	<title>FeelFlow.ai</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<style>
		#output-container {
	        display: flex;
	        flex-direction: row;
	        align-items: center;
	        flex-wrap: wrap;
	    }
		#output-song {
			display: flex;
			width: 1200px;
			height: 300px;
			position: absolute;
			text-align: center;
			top: 700px;
			left: 50%;
			transform: translate(-50%);
			padding-bottom: 20px;
			justify-content: center;
			gap: 50px;
			align-items: center;
			font-family: Ubuntu, sans-serif;
			font-size: 20px;
			color: white;
			flex-direction: row;
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
	<img id="logo" src="logo/logo2.png" alt="FeelFlow.ai logo">


	<!-- <div id="main_box">  -->
	<div id="main_container">
		<div id="main_form">
			<textarea id="main_box" rows="5" cols="50" placeholder="How are you feeling today?"></textarea> <!-- box where the user types in the text -->

		</div>
		<div id="button">
	        <!-- <button id="button" onclick="showOutput()">Give me a song recommendation!</button> -->
	         <a class="btn btn-1" onclick="showOutput()" id="submitButton">
		      <!-- <svg> -->
		        <rect x="0" y="0" fill="none" width="100%" height="100%"/>

		      <!-- </svg> --> 
		     Give me a song recommendation!
		    </a>

	    </div>

	    <form action="playlist.php" method="POST">
	    	<div id="output-container">
			    <div id="output-song">
			    	<input type="hidden" name="artist" id="inputArtist" value='hi'>
					<input type="hidden" name="title" id="inputTrack">
					<input type="hidden" name="album" id="inputAlbum">
					<input type="hidden" name="length" id="inputLength">
					<input type="hidden" name="genre" id="inputGenre">
					<input type="hidden" name="album_type" id="inputAlbumType">
			    </div>
			   
		    </div>
		</form>
	    
	</div> <!-- main container -->
	<!-- <div id="playlist">
		My Playlist

	</div> -->



	
	<!-- </div> -->

	<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>

	<script> /*JavaScript*/
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


  		document.querySelector("#main_box").onsubmit = function() {
  			console.log("Hello")
  		}

  		document.querySelector("#main_box").addEventListener("keydown", function (e) {
		    if (e.key === "Enter" && !e.shiftKey) {
		        e.preventDefault(); // Prevent a newline character in the textarea
		        // Trigger the hidden button click event
		        document.querySelector("#submitButton").click();
		    }
		});


  		const chatGPT = async (messages, parameters = {}) => {
            const apikey = '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';
            if (messages[0].constructor === String) return await chatGPT([['user', messages[0]]]);
            messages = messages.map(line => ({ role: line[0], content: line[1].trim() }))
            console.log(1)
            const response = await fetch('https://api.openai.com/v1/chat/completions', {
               method: 'POST',
               headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${apikey}` },
               body: JSON.stringify({ model: 'gpt-3.5-turbo', messages, ...parameters }),
            });
            const data = await response.json();
            if (data?.error?.message) throw new Error(data.error.message);
            return data.choices[0].message.content.trim();
         };
        async function showOutput() {
            var inputText = document.getElementById("main_box").value.trim();
            if(!inputText)alert('please describe')
            inputText = `DESC::${inputText}`
            let response
            try{
               
                response = await chatGPT([
                  ['system', `The assistant's job is to recommend a playlist with ten songs and the artist names that matches what the user is describing. The goal is to type in that song into spotify.`],
                  ['user', 'DESC::I am feeling lonely and sad.'],
                  ['assistant', 'idontwannabeyouanymore by Billie Eilish'],
                  ['user', 'DESC::I went to the shop today with my friends!'],
                  ['assistant', 'Oops!...I Did It Again by Britney Spears'],
                  ['user', 'DESC::Will AI take over the world?'],
                  ['assistant', 'Thriller by Michael Jackson'],
                  ['user', inputText],
                  ['user', 'DESC::My friend'],
                  ['assistant', 'Raise Your Glass by P!nk'],
                  ['user', inputText]
               ], { temperature: 0.8 })
            }catch(e){
               console.log(e.message)
               return;
            }
            var outputSong = document.getElementById("output-song");
            console.log(response)
            const [songTitle, artistName] = response.split(" by ");
            console.log([songTitle, artistName])
            console.log(songTitle)
            console.log(artistName)           

            const clientID = "c5a2543e00af4f9fbb83eaaa25676031"
	        const clientSecret = "98a6e127ffec44679697189371abb86d"

			let accessToken;


	        const _getToken = () => {
			    return $.ajax({
			        url: 'https://accounts.spotify.com/api/token',
			        method: 'POST',
			        headers: {
			            'Content-Type': 'application/x-www-form-urlencoded',
			            'Authorization': 'Basic ' + btoa(clientID + ':' + clientSecret)
			        },
			        data: 'grant_type=client_credentials',
			        dataType: 'json'
			        
			        
			    });
			}
			
			const endpoint = "https://api.spotify.com/v1/search?q=%2520isrc%3A"+songTitle+"%2520artist%3A"+artistName+"&type=track,album,artist&limit=20"
			console.log(endpoint)

			_getToken().done(function(data) {
			    const accessToken = data.access_token;
			    console.log(accessToken, "hi");
			    $.ajax({
					url: endpoint,
					// dataType: "json",
					method: "GET",
					headers: {
						"Authorization": `Bearer ${accessToken}`
					},
					
					success: function(data) {
						console.log(data)
						console.log("HIIIII")
						console.log(data.tracks.items[0])
						console.log(data.tracks.items[0].artists[0].name)
						console.log(data.tracks.items[0].name)
						console.log(data.tracks.items[0].duration_ms)
						// console.log(data.tracks.items[0].description)
						console.log(data.tracks.items[0].preview_url)
						// console.log(data.albums.items[0].images[1].url)
						// console.log(data.albums.items[0].name)
						console.log(data.tracks.items[0].album.name)
						console.log(data.tracks.items[0].album.images[1].url)
						// console.log(data.artists.items[0].genres[1])
						console.log(data.albums.items[0].type)
						const artists = data.artists.items
						let genre = "N/A"
						if (artists.length != 0) {
						    genre = data.artists.items[0].genres[1]
						    // console.log(genre);
						} 
						console.log(genre)
						document.querySelector("#output-song").innerHTML = ""
						createSong(data.tracks.items[0].name, data.tracks.items[0].album.name, data.tracks.items[0].artists[0].name, data.tracks.items[0].duration_ms, data.tracks.items[0].album.images[1].url, data.tracks.items[0].preview_url, genre, data.albums.items[0].type)
						// document.querySelector("#button2").style.display = "block"

					},
					error: function(error) {
						alert("AJAX error")
						console.log(error)
					}
				})
			}).fail(function(error) {
			    console.error('Failed to get access token:', error);
			});
			



           
            const divElem = document.createElement('div');
            divElem.textContent = response;
            // document.querySelector("#output-song").innerHTML = ""
            // createSong(outputSong)
            // outputSong.appendChild(divElem);
            // }
            // const divElem = document.createElement('div');
            // divElem.textContent = color.reasonForRecommendation
            // outputText.appendChild(divElem);
            
            function createSong(track, album, artist, duration_ms, cover, preview, genre, album_type){


            	// track.appendChild(divElem);

            	const albumContainer = document.createElement("div")
            	const imgContainer = document.createElement("img")
            	const trackName = document.createElement("div")
            	const albumName = document.createElement("div")
            	const albumType = document.createElement("div")
				const artistName = document.createElement("div")
				const genreName = document.createElement("div")
				const duration = document.createElement("div")
				const audioContainer = document.createElement("div")
				const audio = document.createElement("audio")
				const buttonImg = document.createElement("img")

				imgContainer.src = cover
				imgContainer.alt = album + " Cover"

				audio.src = preview
				audio.controls = true

				artistName.innerHTML = artist
				trackName.innerHTML = track
				// albumContainer.innerHTML = albumName
				albumName.innerHTML = album

				var durationInMs = duration_ms; // Your duration in milliseconds

				var seconds = Math.floor(durationInMs / 1000);

				var minutes = Math.floor(seconds / 60);

				seconds = seconds % 60;

				seconds = seconds < 10 ? '0' + seconds : seconds;

				var durationFormatted = minutes + ":" + seconds;

				duration.innerHTML = durationFormatted

				albumContainer.id = "albumContainer"
				audioContainer.id = "audioContainer"
				audioContainer.appendChild(audio)


				document.querySelector("#output-song").appendChild(albumContainer)
				// albumContainer.appendChild(imgContainer)
				albumContainer.appendChild(albumName)
				albumContainer.appendChild(imgContainer)

				document.querySelector("#output-song").appendChild(trackName)
				// document.querySelector("#output-song").appendChild(albumName)
				document.querySelector("#output-song").appendChild(artistName)
				document.querySelector("#output-song").appendChild(duration)
				document.querySelector("#output-song").appendChild(audioContainer)
				


            }



        }

		
	</script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>
</html>