<!DOCTYPE html>
<?php 
	include './inc/class/ytdata.class.php';

	if(isset($_GET['v'])) {
		if(strlen($_GET['v']) > 13) {
			$v = htmlentities(substr($_GET['v'], strpos($_GET['v'], 'v=')+2, 11));
		} else if ( strlen($_GET['v']) == 11 ) {
			$v = $_GET['v'];
		} else {
		    $v = null;
		}
	
		try {
		    $data = new ytdata('http://gdata.youtube.com/feeds/api/videos/'.$v.'?v=2&alt=jsonc');
		} catch (Exception  $e ) {
			unset($v);
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Youtube <--> Repeat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
	<link href="./assets/css/custom.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
  	<!--
  		<div id="backgroundtext">
		//<?php
		//	for($i; $i < 50; $i++) {echo '<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span><br>';}
		//?>
        </div>
    -->	
    <div class="container-narrow well">
        <div class="masthead">
            <h3 class="muted">Youtube < -<span style="color: red;">- >repeat</span></h3>
        </div>
        <hr>
	    <div class="jumbotron">
			<h1></h1>
			<?php
		    	if($data->get_errorCode()){
		    	    echo "<p>" . $data->get_errorCode() . " : " . $data->get_errorMsg() . "</p><br>";
		    	    echo '<a class="btn btn-danger"  onClick="history.go(-1);return true;">Go Back</a>';
		    	    return;
		    	}
		    	 if(isset($v)){
		    	    
		    	    echo '<img src=' . $data->get_thumbnail() . '>';
		    	    echo '<h2 class="well well-small">' . $data->get_title() . '<br></h2>';
		    	    echo '<span class="icon-eye-open"></span><span class="lead">' . number_format($data->get_viewCount()) . ' </span>';
    				echo '<span class="icon-thumbs-up"></span><span>' . $data->get_likeCount() . ' </span>';
    				echo '<span class="icon-time"></span><span id="CurrentTime" ></span>/<span>' . $data->get_duration() . ' </span>';
    				echo '<span class="icon-share"></span><span> <a href=/repeat/?v=' . $v .  '>' . $_SERVER["HTTP_HOST"] . '/repeat/?v=' . $v . '</a> </span>';
		    	    // Button to trigger modal
		    	    echo '<br>';
				    echo '<a href="#myModal" role="button" class="btn btn-small" data-toggle="modal">Description</a>';
				    // Modal
    				 echo '<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
    				     echo '<div class="modal-header">';
    					     echo '<h3 id="myModalLabel">Description</h3>';
    				     echo '</div>';
    				     echo '<div class="modal-body">';
    					     echo '<span>' . $data->get_description() . '</span>';
    				     echo '</div>';
    				     echo '<div class="modal-footer">';
    				    	 echo '<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>';
    				     echo '</div>';
    				 echo '</div>';
    				 
    				 
        			// Submit link
					echo '<form>';
						echo '<input type="text" name="v" size="50" class="input-xxlarge" placeholder="Enter youtube link here"><br>';
						echo '<input type="submit" value="Repeat!" class="btn btn-large btn-danger">';
				    echo '</form>';
				    
				    
				    				
					// Controls
					echo '<div class="media">';
						echo '<div class="progress progress-danger active pull-left">';
							echo '<div class="bar" style="width: 0%"></div>';
						echo '</div>';
					    echo '<div class="media-body">';
					    	echo'<div id="progressbar"></div>';
							echo '<div class="btn-group">';
						
								echo '<a class="btn btn-inverse" id="start"><i class="icon-white icon-step-backward"></i></a>';
								echo '<a class="btn btn-inverse" id="play" style="display: none;"><i class="icon-white icon-play"></i></a>';
								echo '<a class="btn btn-inverse" id="pause"><i class="icon-white icon-pause"></i></a>';
								echo '<a class="btn btn-inverse" id="mute"><i class="icon-white icon-volume-off"></i></a>';
								echo '<a class="btn btn-inverse" id="unmute" style="display: none;"><i class="icon-white icon-volume-up" ></i></a>';
								echo '<a class="btn btn-inverse" id="showbtn"><span class="icon-white icon-chevron-right" ></span></a>';
								echo '<a class="btn btn-inverse" id="hidebtn" style="display: none;"><span class="icon-white icon-chevron-down" ></span></a>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
					
					// Player
					echo '<div id="player" style="visibility:hidden;"></div>';
					
		    	} else {
		    	    // Submit link
					echo '<form>';
						echo '<input type="text" name="v" size="50" class="input-xxlarge" placeholder="Enter youtube link here"><br>';
						echo '<input type="submit" value="Repeat!" class="btn btn-large btn-danger">';
				    echo '</form>';
		    	}
			?>
		</div>

		<div class="footer">
            <p>&copy; Bahbi 2012 - <?php echo date("Y"); ?> <a href=""></a></p>
        </div>
    </div>   



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./assets/js/bootstrap-transition.js"></script>
    <script src="./assets/js/bootstrap-alert.js"></script>
    <script src="./assets/js/bootstrap-modal.js"></script>
    <script src="./assets/js/bootstrap-dropdown.js"></script>
    <script src="./assets/js/bootstrap-scrollspy.js"></script>
    <script src="./assets/js/bootstrap-tab.js"></script>
    <script src="./assets/js/bootstrap-tooltip.js"></script>
    <script src="./assets/js/bootstrap-popover.js"></script>
    <!--<script src="./assets/js/bootstrap-button.js"></script>-->
    <script src="./assets/js/bootstrap-collapse.js"></script>
    <script src="./assets/js/bootstrap-carousel.js"></script>
    <script src="./assets/js/bootstrap-typeahead.js"></script>
    <!--<script src="./assets/js/bootstrap-progressbar.js"></script>-->

	<script>
	   
	    
        // 2. This code loads the IFrame Player API code asynchronously.
          var tag = document.createElement('script');
    
          tag.src = "https://www.youtube.com/iframe_api";
          var firstScriptTag = document.getElementsByTagName('script')[0];
          firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    
          // 3. This function creates an <iframe> (and YouTube player)
          //    after the API code downloads.
          var player;
          var id = '<?php echo $v; ?>';
          function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
              height: '390',
              width: '640',
              videoId: id,
              playerVars: { 'controls': 0 , 'enablejsapi': 1 },
              events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange,
                'onPlaybackQualityChange': onPlayerQuality
              }
            });
          }
          // 4. The API will call this function when the video player is ready.
          function onPlayerReady(event) {
            event.target.playVideo();
            setInterval(updatePlayerInfo, 0);
            $( "#progressbar" ).progressbar({ max: player.getDuration() });
          }
    
          function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.ENDED) {
              event.target.playVideo();
            }
          }
          function stopVideo() {
            player.stopVideo();
          }
          function onPlayerQuality(event){
            player.setPlaybackQuality("highres");
          }
            function updateHTML(elmId, value) {
                document.getElementById(elmId).innerHTML = value;
            }
          function updatePlayerInfo(){
            if (player && player.getDuration()) {
                $( "#progressbar" ).progressbar({ value: player.getCurrentTime() });
                updateHTML("CurrentTime", (player.getCurrentTime()).toFixed(2));
            }
          }

        
	</script>
	<script>
    	document.getElementById('start')['onclick'] = function() {
    		player.seekTo(0, true);	
    	}
    	
    	document.getElementById('play')['onclick'] = function() {
    		document.getElementById('play').style.display = 'none';
    		document.getElementById('pause').style.display = 'inherit';	
    		player.playVideo();
    	}
    	
    	document.getElementById('pause')['onclick'] = function() {
    		document.getElementById('play').style.display = 'inherit';
    		document.getElementById('pause').style.display = 'none';
    		player.pauseVideo()
    	}
    	
    	document.getElementById('mute')['onclick'] = function() {
    		document.getElementById('mute').style.display = 'none';
    		document.getElementById('unmute').style.display = 'inherit';	
    		player.mute()
    	}
    	
    	document.getElementById('unmute')['onclick'] = function() {
    		document.getElementById('mute').style.display = 'inherit';	
    		document.getElementById('unmute').style.display = 'none';	
    		player.unMute()
    	}
    	
    	document.getElementById('showbtn')['onclick'] = function() {
    		document.getElementById('player').style.visibility = 'visible';
    		document.getElementById('showbtn').style.display = 'none';	
    		document.getElementById('hidebtn').style.display = 'inherit';						
    	}
    	
    	document.getElementById('hidebtn')['onclick'] = function() {
    		document.getElementById('player').style.visibility = 'hidden';
    		document.getElementById('showbtn').style.display = 'inherit';
    		document.getElementById('hidebtn').style.display = 'none';
    	}

	</script>

  </body>
</html>
