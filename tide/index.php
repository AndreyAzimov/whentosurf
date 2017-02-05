<!DOCTYPE html>
<html class="embedded-chat-closed">
<head>

  <link rel="stylesheet" href="./style.css">

  <meta http-equiv="Content-Language" content="en-us" />
  <meta name="google" value="notranslate" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <meta name="apple-mobile-web-app-title" content="When to Surf">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

  <script type="text/javascript" src="../script/jquery.min.js"></script>

  <link rel="stylesheet" href="../style/weather-icons.min.css" />
  <link rel="stylesheet" href="../style/weather-icons-wind.min.css" />
  <script type="text/javascript" src="../script/jquery.canvasjs.min.js"></script>

  <title>When to surf</title>

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


<?php

include '../logic.php';    

?>


<?php

  // _________________________________________________________________________
  //                         PRINT ALL SHIT IN HTML

echo "<div id=\"today_date\">" . $tomorrow_formated . "</div>";
echo "<div id=\"today_date\">" . $location_print . "</div>";
//echo "<div id=\"today_date\">Best time is" . " ". $best_time . ":00". "</div>";

echo '


<div id="alldata">

  <table id="tide_table">
    <tr>
      <th id="table_column_names">Time</th>
      <th id="table_column_names">Tide</th>
      <th id="table_column_names">Tide rating</th>
      <th id="table_column_names">Wave height</th>
      <th id="table_column_names">Wave height rating</th>
      <th id="table_column_names">Swell period</th>
      <th id="table_column_names">Swell direction</th>
      <th id="table_column_names">Wind direction</th>
      <th id="table_column_names">Wind speed</th>
      <th id="table_column_names">Total rating</th>

    </tr>
    ';

    for ($i = $from; $i <= $to; $i++) {

      if ($total_rating[$i] == $best_rating) {
        
        echo "<tr>";
        echo "<td bgcolor = #8bc34a >" . $hours[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $tide_types_hours[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $tide_rating[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $wave_heights[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $waves_height_rating[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $swell_periods[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $swell_directions[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $wind_directions[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $wind_speeds[$i] . "</td>";
        echo "<td bgcolor = #8bc34a >" . $total_rating[$i] . "</td>";
        echo "\r\n";
        echo "</tr>";

      } else {

        echo "<tr>";
        echo "<td>" . $hours[$i] . "</td>";
        echo "<td>" . $tide_types_hours[$i] . "</td>";
        echo "<td>" . $tide_rating[$i] . "</td>";
        echo "<td>" . $wave_heights[$i] . "</td>";
        echo "<td>" . $waves_height_rating[$i] . "</td>";
        echo "<td>" . $swell_periods[$i] . "</td>";
        echo "<td>" . $swell_directions[$i] . "</td>";
        echo "<td>" . $wind_directions[$i] . "</td>";
        echo "<td>" . $wind_speeds[$i] . "</td>";
        echo "<td>" . $total_rating[$i] . "</td>";
        echo "\r\n";
        echo "</tr>";


      }

    }

    echo '

  </table>
</div>

';

echo '


<div id="alldata">

  <table id="tide_table">
    ';

    for ($i = 0; $i <= 3; $i++) {
      
      echo "<tr>";

      echo "<td>" . $tide_types[$i] . "</td>";
      echo "<td>" . $tide_times[$i] . "</td>";

      echo "</tr>";
    }

      echo "<td> Sunrise: " . $sunrise . "</td>";
      echo "<td></td>";
      echo "<td> Sunset: " . $sunset . "</td>";
      echo "<td></td>";

    echo '

  </table>
</div>

';
 
// _________________________________________________________________________
//                                  PHP CODE END

?>


<div id="location">
  <a href="<?php echo $google_maps_link; ?>" target="_blank" style="color:white"><?php echo $location; ?></a>
  <div id="location">
  </div>

<div id="feedbackcontainer" style="position: fixed; right: 0px; bottom: 80px; background: none; height: 120px; width: 40px; font-size: 14px; font-family: Arial, sans-serif;">
  <button id="feedbackbutton" style="transform: rotate(-90.0deg); background: black; border-radius: 4px; width: 120px; border: solid 1px #e3e3e3; letter-spacing: 1; padding: 5px 5px; color: #FFF; font-weight: bold; cursor: pointer; float: right; margin-top: 45px; margin-right: -45px" onclick="extendFeedback();">Feedback</button>
  <div id="feedbackform" style="display: none; position: relative; top: -70px; left: 5px">
    <input type="text" id="feedbackemail" name="email" placeholder="your@email.com" style="width: 290px; border-radius: 3px; padding: 2px; margin-bottom: 5px;" /><br>
    <textarea id="feedbackmessage" style="width: 290px; height: 150px; border-radius: 3px; padding: 2px; margin-bottom: 5px; font-size: 12px; font-family: Arial, sans-serif;"></textarea><br>
    <button onclick="submitFeedback();" style="background: black; border-radius: 4px; width: 120px; border: solid 1px #e3e3e3; color: #FFF; font-weight: bold; cursor: pointer;">Send</button>
  </div>
</div>

<script>
var feedbackform_url = '../contact.php';
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

  <div class="bg"></div>

</body>
</html>
