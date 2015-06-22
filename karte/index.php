<?php
   if (!isset($_GET['text']))
      header('Location: ./?text=Frohe%20Weihnachten');
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Grußkarte</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
   <div class="container">
      <div class="karte">
         <img src="" alt="Bild">
         <p class="text"><?= $_GET['text'] ?></p>
      </div>

      <ul class="motive">
         <li><img src="images/foto-1.jpg" alt="1"></li>
         <li><img src="images/foto-2.jpg" alt="2"></li>
         <li><img src="images/foto-3.jpg" alt="3"></li>
         <li><img src="images/foto-4.jpg" alt="4"></li>
         <li><img src="images/foto-5.jpg" alt="5"></li>
         <li><img src="images/foto-6.jpg" alt="6"></li>
      </ul>

      <ul class="credits">Credits:
         <li><a href="http://www.flickr.com/photos/manugomi/3027388552/">manugomi/3027388552/</a></li>
         <li><a href="http://www.flickr.com/photos/batterypower/2956906776/">batterypower/2956906776/</a></li>
         <li><a href="http://www.flickr.com/photos/kelseyj_88/3831046936/">kelseyj_88/3831046936/</a></li>
         <li><a href="http://www.flickr.com/photos/tabbo107/4890777616/">tabbo107/4890777616/</a></li>
         <li><a href="http://www.flickr.com/photos/das_sabrinchen/3107029674/">das_sabrinchen/3107029674/</a></li>
         <li><a href="http://www.flickr.com/photos/anshu_10us/3582004216/">anshu_10us/3582004216/</a></li>
      </ul>
   </div>

   <script>
      var default_card = 3;

      window.onload = function() {
         var card = getQueryStringParameterByName('karte');
         if (!card) {
            card = default_card;
            updateQueryStringParameter('karte', card);
         }
         var img = document.querySelector('.karte img');
         var src = 'images/foto-' + card + '.jpg';
         img.setAttribute('src', src);
      };

      document.querySelector('.motive').addEventListener('click', function(event) {
         event.preventDefault();
         if (event.target.alt) {
            updateQueryStringParameter('karte', event.target.alt);
            window.onload();
         }
      }, false);

      function getQueryStringParameterByName(name) {
         name = name.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
         var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
         var results = regex.exec(location.search);
         return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
      }

      function updateQueryStringParameter(key, value) {
         var uri = window.location.href;
         var re = new RegExp('([?|&])' + key + '=.*?(&|$)', 'i');
         separator = uri.indexOf('?') !== -1 ? '&' : '?';
         if (uri.match(re)) {
            uri = uri.replace(re, '$1' + key + '=' + value + '$2');
         }
         else {
            uri = uri + separator + key + '=' + value;
         }
         window.history.replaceState({}, '', uri,'');
      }
   </script>
</body>
</html>