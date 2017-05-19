<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/fi_FI/sdk.js#xfbml=1&version=v2.8";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script>window.twttr = (function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0],
  t = window.twttr || {};
if (d.getElementById(id)) return t;
js = d.createElement(s);
js.id = id;
js.src = "https://platform.twitter.com/widgets.js";
fjs.parentNode.insertBefore(js, fjs);

t._e = [];
t.ready = function(f) {
  t._e.push(f);
};

return t;
}(document, "script", "twitter-wjs"));</script>

<div class="home">
  <div class="container">
    <div class="cover" id="cover"></div>
    <div class="popup" id="popup">
<div class="close-line">
<div id="close" class="close">X</div>
</div>
<div class="popup-ad" id="popupAd"></div>
<p class="popup-text" id="popupText"></p>
    </div>
    <div class="row">
      <div style="margin-bottom:30px" class="twelve columns">
      </div>
      <div class="twelve columns" style="text-align:center">
      <div class="home-logo" id="homeLogo"><img src="seura.png"></div>
      <div style="width:20%;float:left;margin-top: 5%;"><h4 style="font-size:2.5em">VS</h4></div>
      <div class="visitor-logo" id="visitorLogo"><img src="seura.png"></div>
    </div>
    <div class="twelve columns" style="text-align:center">
    <div class="home-name" id="homeName" style="float:left"><h3>Kotijoukkue</h3></div>
    <div class="visitor-name" id="visitorName" style="float:right"><h3>Vierasjoukkue</h3></div>
  </div>
      <div class="twelve columns">
        <div id="gameDate" class="game-date"></div>
        <div class="divider"><h3 style="font-size:1.5em">-</h3></div>
        <div id="gamePlace" class="game-place"></div>
  </div>

  <div id="gameShare" class="game-share">
    <div class="share-header">
    </div>
      <div class="facebook" id="facebook">
      <div data-href="" data-layout="button"data-mobile-iframe="true">
      <a style="background-color:#2A279B;color:white"class="fb-xfbml-parse-ignore" target="_blank" href="">
      <i class="ion-social-facebook"></i></a>
      </div>
      </div>

      <div class="twitter" id="twitter">
      <a href="" style="background-color:#00A4E4;color:white">
      <i class="ion-social-twitter"></i></a>
      </div>

      <div class="whatsapp" id="whatsapp">
      <a style="background-color:#2A9B27;color:white" href="">
      <i class="ion-social-whatsapp"></i></a>
      </div>

  </div>

  </div>
  </div>
</div>
