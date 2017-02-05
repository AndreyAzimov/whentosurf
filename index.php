<!DOCTYPE html>
<html class="embedded-chat-closed">
<head>

  <link rel="stylesheet" href="./style.css">

  <meta http-equiv="Content-Language" content="en-us" />
  <meta name="google" value="notranslate" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <meta property="og:image" content="https://whentosurf.co/img/"/>

  <meta name="apple-mobile-web-app-title" content="When to Surf">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

  <script type="text/javascript" src="./script/jquery.min.js"></script>

  <link rel="stylesheet" href="./style/weather-icons.min.css" />
  <link rel="stylesheet" href="./style/weather-icons-wind.min.css" />
  <script type="text/javascript" src="./script/jquery.canvasjs.min.js"></script>

  <script>

// Google Analitics

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-51392658-4', 'auto');
ga('send', 'pageview');
</script>



</head>
<body>




  <p id="demo"></p>

  <script>
    getLocation()
    var x = document.getElementById("demo");

    function getcookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    function setcookie(cookieName,cookieValue,nDays) {
     var today = new Date();
     var expire = new Date();
     if (nDays==null || nDays==0) nDays=1;
     expire.setTime(today.getTime() + 3600000*24*nDays);
     document.cookie = cookieName+"="+escape(cookieValue)
     + ";expires="+expire.toGMTString();
   }


   function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }

  function showPosition(position) {
    var location = position.coords.latitude + "," + position.coords.longitude

    var date = new Date()

    var reload = false;

    if (getcookie("latitude") == "") {
      reload = true;
    }

    setcookie("latitude", position.coords.latitude, 365);
    setcookie("longitude", position.coords.longitude,365);
    console.log(position.coords.latitude);
    console.log(position.coords.longitude);
    setcookie("test123", "123",365);
    console.log('cookie set!');

    if (reload == true) {
      window.location.reload();
    }
  }

</script>

<?php

include 'logic.php';

?>

  <div class="alldata">

    <div id="weatherIconDegree"> <i class="wi wi-sleet"></i> <?=$best_temperature?>&#176</div>

    <div id="locationName"><?=$location_print?></div>

    <div id="besttime">

      <div id="best">Best surf time:</div>

<?php

if ($supermax[max] <= 2 ) {
  echo "<div id=\"time\">Surf is bad today, maybe work?</div>";
} else {
  echo "<div id=\"time\">" . ($best_time - 1) . ":00" . " - " . ($best_time + 1) . ":00" . "</div>";
}

?>



    </div>

    <div id="stars"><?=$best_rating_stars?></div>

    <div class="recom">

    <?php

    if ($levels == "For pro") {

    echo'
      <div id="circleMini" style="background: #f13b44;"></div>
      ';

    } elseif ($levels == "Good for beginners") {

      echo'
      <div id="circleMini" style="background: #2BDE73;"></div>

      ';

    } elseif ($levels == "Small waves today") {

      echo'
      <div id="circleMini" style="background: lightgray;"></div>
      ';

    }

    ?>

      <div id="recomendation"><?= $levels ?></div>
    </div>

    <div class="waves">
      <div class="circle"><img src="./img/wave.png" /></div>
      <h3 id="wavesHeight"> <?= $best_waves ?></h3>
      <h3 id="ft-m">m</h3>
    </div>

    <div class ="wind">
      <div id="wind-icon"><i class="wi wi-strong-wind"></i></div>
      <div id="wind-speed"><?= $best_wind_speed . " km/h" ?></div>
    </div>

  </div>

  <div id = "details">
    <p></p>
    <a href="/tide/?city=<?=$city_name_z?>" target="_blank" style="color: white">Details</a>
    <p></p>
    <a href="<?php echo $google_maps_link; ?>" target="_blank" style="color: white"><?php echo $location; ?></a>

    <?php

    $st = "target=\"_blank\" style=\"color: white\"";

    echo "<p></p>";

    echo "Nearby: ";

    for ($i=1; $i < count($nearest_cities); $i++) { 

      $url_city = "https://whentosurf.co/?city=" . $nearest_cities[$i];

      echo "<a href=\"" . $url_city . "\"" . $st . ">" . $nearest_cities[$i] .  "</a>" . " ";
    }

    ?>

  </dev>

  <div class="bg"></div>

<div id="feedbackcontainer" style="position: fixed; right: 0px; bottom: 80px; background: none; height: 120px; width: 40px; font-size: 14px; font-family: Arial, sans-serif;">
  <button id="feedbackbutton" style="transform: rotate(-90.0deg); background: black; border-radius: 4px; width: 120px; border: solid 1px #e3e3e3; letter-spacing: 1; padding: 5px 5px; color: #FFF; font-weight: bold; cursor: pointer; float: right; margin-top: 45px; margin-right: -45px" onclick="extendFeedback();">Feedback</button>
  <div id="feedbackform" style="display: none; position: relative; top: -70px; left: 5px">
    <input type="text" id="feedbackemail" name="email" placeholder="your@email.com" style="width: 290px; border-radius: 3px; padding: 2px; margin-bottom: 5px;" /><br>
    <textarea id="feedbackmessage" style="width: 290px; height: 150px; border-radius: 3px; padding: 2px; margin-bottom: 5px; font-size: 12px; font-family: Arial, sans-serif;"></textarea><br>
    <button onclick="submitFeedback();" style="background: black; border-radius: 4px; width: 120px; border: solid 1px #e3e3e3; color: #FFF; font-weight: bold; cursor: pointer;">Send</button>
  </div>
</div>

<script>
var feedbackform_url = 'contact.php';
var feedbackform_emailsubject = 'Feedback Form';

var feedbackform_fc = document.getElementById('feedbackcontainer');
var feedbackform_fb = document.getElementById('feedbackbutton');
var feedbackform_ff = document.getElementById('feedbackform');
var feedbackform_fe = document.getElementById('feedbackemail');
var feedbackform_fm = document.getElementById('feedbackmessage');
function extendFeedback() {
  feedbackform_fc.style.background = '#EEF';
  feedbackform_fc.style.width = '320px';
  feedbackform_fc.style.height = '240px';
  feedbackform_fc.style.bottom = '5px';
  feedbackform_fb.style.marginRight = '272px'
  feedbackform_ff.style.display = 'block';
  feedbackform_fb.onclick = function() { closeFeedback(); }
}
function closeFeedback() {
  feedbackform_fc.style.background = 'none';
  feedbackform_fc.style.width = '40px';
  feedbackform_fc.style.height = '120px';
  feedbackform_fc.style.bottom = '80px';
  feedbackform_fb.style.marginRight = '-45px'
  feedbackform_ff.style.display = 'none';
  feedbackform_fb.onclick = function() { extendFeedback(); }
}
function submitFeedback() {
  if (feedbackform_fe.value.indexOf('@') == -1) { alert('You need to enter a valid email address'); return; }
  feedbackform_ff.innerHTML = '<p style="text-align: center; font-size: 16px; margin-top: 20px;">Message Sent</p>';
  setTimeout(function() { closeFeedback(); }, 2000);

  // Ajax Post
  var feedbackform_lookup = "email=" + encodeURIComponent(feedbackform_fe.value) + '&subject=' + encodeURIComponent(feedbackform_emailsubject) + '&message=' + encodeURIComponent(feedbackform_fm.value); // $_POST['email']
  if (window.XMLHttpRequest) { feedbackform_xmlhttp=new XMLHttpRequest(); } else { feedbackform_xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  feedbackform_xmlhttp.onreadystatechange=function() {
    if (feedbackform_xmlhttp.readyState==4 && feedbackform_xmlhttp.status==200) {
      console.log(feedbackform_xmlhttp.responseText);
    }
  }
  feedbackform_xmlhttp.open("POST",feedbackform_url,true);
  feedbackform_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  feedbackform_xmlhttp.setRequestHeader("Content-length", feedbackform_lookup.length);
  feedbackform_xmlhttp.setRequestHeader("Connection", "close");
  feedbackform_xmlhttp.send(feedbackform_lookup);
}
</script>
<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
  #mc_embed_signup{background:transparent; color: white; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%; padding-top: 10vh;}
  /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
     We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//whentosurf.us15.list-manage.com/subscribe/post?u=b9909498bfcf0094d3b867d70&amp;id=82d3a4c6c8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
  <label for="mce-EMAIL">Get updates on when to surf for the best waves in <?=$location_print ?></label>
  <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Your email" required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_b9909498bfcf0094d3b867d70_82d3a4c6c8" tabindex="-1" value=""></div>
    <style type="text/css">
     #mc_embed_signup .button {background-color: #2dafe6}
     #mc_embed_signup .button:hover {background-color: #2b64ad}
    </style>

    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>

<!--End mc_embed_signup-->

<!--   <div align="right">
   <a href="http://twitter.com/andreyazimov>" target="_blank" style="color: white">@andreyazimov</a>
  </dev> -->


</body>

<head>
    <title>When to surf in <?=$location_print ?></title>

</head>
</html>
