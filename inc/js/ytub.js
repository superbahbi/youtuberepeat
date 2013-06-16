
var repeat = 1;
var autoplay = 1;
var params = { allowScriptAccess: "always" };
var atts = { id: "yplayer" };
swfobject.embedSWF("http://www.youtube.com/v/"+videoId+"?enablejsapi=1&playerapiid=ytplayer&version=3&loop=1&autoplay="+autoplay,
                 "content", "768", "600", "8", null, null, params, atts);

function onYouTubePlayerReady(playerId)
{
   player = document.getElementById("yplayer");
   if(start != null || end != null)
      setInterval("abRepeat(start, end)", 1000);
   else
      player.addEventListener("onStateChange", "playerStateChange");
}

function playerStateChange(newState)
{
   if(newState == 0 && repeat == 1)
      player.seekTo(0);
}

function abRepeat(start, end)
{
   if(start == null)
      start = 0;
   if(end == null)
      end = player.getDuration()-1;
   if(player.getCurrentTime() > end)
   {
      player.seekTo(start);
   }
}
function play(id)
{
    player[id].playVideo();
}

function pause(id)
{
    player[id].pauseVideo();
}

function stop(id)
{
    player[id].stopVideo();
}

function mute(id)
{
    player[id].mute();
}

function unmute(id)
{
    player[id].unMute();
}

