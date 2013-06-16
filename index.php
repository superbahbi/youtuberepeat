<!DOCTYPE html>
<?php 
	include './inc/class/ytdata.class.php';
	
	$ytdata = new ytdata();
	
	// TO DO
	// Parse youtu.be link
	if(isset($_GET['v'])) {
		if(strlen($_GET['v']) > 13) {
			$v = htmlentities(substr($_GET['v'], strpos($_GET['v'], 'v=')+2, 11));
		} else if ( strlen($_GET['v']) == 11 ) {
			$v = $_GET['v'];
		} else {
			echo 'Error!';
		}
		$ytdata->url = 'http://gdata.youtube.com/feeds/api/videos/'.$v.'?v=2&alt=jsonc';
		try {
		$data = $ytdata->get_api_data();
		} catch (Exception  $e ) {
				unset($v);
				echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Pudditube</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
	<link href="./assets/css/custom.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">
	

	<!--<link rel="stylesheet" href="./assets/css/font-awesome.css">-->
	
	<script src="./build/jquery.js"></script>	
	<script src="./build/mediaelement-and-player.min.js"></script>
	<link rel="stylesheet" href="./build/mediaelementplayer.min.css" />
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
  		<!--<div id="backgroundtext">
		//<?php
		//	for($i; $i < 50; $i++) {echo '<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span>puddi<span style="color: red;">puddi</span><br>';}
		//?>-->
		</div>	
    <div class="container-narrow well">
      <div class="masthead">
        <h3 class="muted">Puddi<span style="color: red;">repeat</span>tube</h3>
      </div>
      <hr>
	    <div class="jumbotron">
			<h1></h1>
			<?php if(isset($v)): ?>
					<?php if(!$v): ?>
					
						<p>Invalid youtube id</p><br> 
						<a class="btn btn-danger"  onClick="history.go(-1);return true;">Go Back</a>
						<?php return; ?>
					<?php endif; ?>
					<!-- Title and Share link -->
				<h2 class="well well-small"> <?php echo $data->data->title; ?><br></h2>
				
				<span class="icon-eye-open"></span><span class="lead"> <?php echo number_format($data->data->viewCount);?></span>
				<span class="icon-thumbs-up"></span><span> <?php echo $data->data->likeCount?></span>
				<span class="icon-share"></span><span> <a href="http://obscureserver.com/repeat/?v=<?php echo $v; ?>" >http://obscureserver.com/repeat/?v=<?php echo $v; ?></a></span>
				<!-- Button to trigger modal --><br>
				<a href="#myModal" role="button" class="btn btn-small" data-toggle="modal">Description</a>
				 
				<!-- Modal -->
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-header">
					<h3 id="myModalLabel">Description</h3>
				  </div>
				  <div class="modal-body">
					<span><?php echo $data->data->description; ?></span>
				  </div>
				  <div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				  </div>
				</div>
					<!-- Submit link -->
					<form>
						<input type="text" name="v" size="50" class="input-xxlarge" value="Puddi a pudditube link here"><br>
						<input type="submit" value="Repeat!" class="btn btn-large btn-danger">
				    </form>
					<!-- Controls -->
					<div class="media">
						<div class="progress progress-danger active pull-left">
							<div class="bar" style="width: 0%"></div>
						</div>
					    <div class="media-body">
							<div class="btn-group">

								<a class="btn btn-inverse" id="start"><i class="icon-white icon-step-backward"></i></a>
								<a class="btn btn-inverse" id="play" style="display: none;"><i class="icon-white icon-play"></i></a>
								<a class="btn btn-inverse" id="pause"><i class="icon-white icon-pause"></i></a>
								<a class="btn btn-inverse" id="stop"><i class="icon-white icon-stop"></i></a>
								<a class="btn btn-inverse" id="mute"><i class="icon-white icon-volume-off"></i></a>
								<a class="btn btn-inverse" id="unmute" style="display: none;"><i class="icon-white icon-volume-up" ></i></a>
								<a class="btn btn-inverse" id="showbtn"><span class="icon-white icon-chevron-right" ></span></a>
								<a class="btn btn-inverse" id="hidebtn" style="display: none;"><span class="icon-white icon-chevron-down" ></span></a>
							</div>
						</div>
					</div>
					<!-- Media element video player -->
					<div id="vid" style="visibility:hidden;" class="span6">
					<video width="640" height="360" id="youtube1" autoplay="1" hd="1">
						<source type="video/youtube" src="http://www.youtube.com/watch?v=<?php echo $v ?>"  />
					</video>
					</div>		
				<?php else: ?>

					<!-- Submit link -->
					<form>
					  <input type="text" name="v" size="50" class="input-xxlarge" value="Puddi a pudditube link here"><br>
					  <input type="submit" value="Repeat!" class="btn btn-large btn-danger">
				   </form>

				<? endif; ?>
		</div>
    </div> <!-- /container      <div class="footer well">
        <p>&copy; Puddi 2012 <a href=""></a></p>
      </div>-->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./assets/js/jquery.js"></script>
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
    <script src="./assets/js/bootstrap-progress.js"></script>

	<script src="./build/mediaelement.js"></script>

	<script>
	MediaElement('youtube1', 
	{
		//enablePluginDebug: true,
		success: function(me) 
		{
			me.addEventListener('timeupdate', function() {
				//document.getElementById('currenttime').innerHTML = me.currentTime;		
				 var current_perc = (me.currentTime/me.duration) * 100;
				 var time = Math.round(current_perc * 10)/10

					if (current_perc>=me.duration) {
						clearInterval(progress);
					} else {
						$('.bar').css('width', (current_perc)+"%");
					}
				if (me.currentTime >= me.duration ) {
					me.setCurrentTime(0);	
				}
				
			}, false);
			
			document.getElementById('start')['onclick'] = function() {
				me.setCurrentTime(0);	
				$('.bar').css('width', 0+"%");
			}
			
			document.getElementById('play')['onclick'] = function() {
				document.getElementById('play').style.display = 'none';
				document.getElementById('pause').style.display = 'inherit';	
				me.play();
			}
			
			document.getElementById('pause')['onclick'] = function() {
				document.getElementById('play').style.display = 'inherit';
				document.getElementById('pause').style.display = 'none';
				me.pause();
			}
			
			document.getElementById('stop')['onclick'] = function() {
				me.stop();
				me.setCurrentTime(0);	
				$('.bar').css('width', 0+"%");
				document.getElementById('play').style.display = 'inherit';
				document.getElementById('pause').style.display = 'none';
			}
			
			document.getElementById('mute')['onclick'] = function() {
				document.getElementById('mute').style.display = 'none';
				document.getElementById('unmute').style.display = 'inherit';	
				me.setVolume(0);
			}
			
			document.getElementById('unmute')['onclick'] = function() {
				document.getElementById('mute').style.display = 'inherit';	
				document.getElementById('unmute').style.display = 'none';	
				me.setVolume(0.8);
			}
			
			document.getElementById('showbtn')['onclick'] = function() {
				document.getElementById('vid').style.visibility = 'visible';
				document.getElementById('showbtn').style.display = 'none';	
				document.getElementById('hidebtn').style.display = 'inherit';						
			}
			
			document.getElementById('hidebtn')['onclick'] = function() {
				document.getElementById('vid').style.visibility = 'hidden';
				document.getElementById('showbtn').style.display = 'inherit';
				document.getElementById('hidebtn').style.display = 'none';
			}
		
		}
	});
	
	</script>
  </body>
</html>
