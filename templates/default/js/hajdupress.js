// JavaScript Document
var celsius = 0;
var wlike = "cloud";
var weather_like = "";
var yqlCallback = function(data) {
   var temp = data.query.results.channel.item;
   celsius = Math.round((temp.condition.temp-32)/1.8);
   weather_like = temp.condition.code;
   if (
   weather_like==0 || 
   weather_like==1 || 
   weather_like==2 || 
   weather_like==3 || 
   weather_like==4 || 
   weather_like==37 || 
   weather_like==38 || 
   weather_like==39 || 
   weather_like==40 || 
   weather_like==45 || 
   weather_like==47
   ) {
      wlike = "storm";
   } 
   
   else if (
   weather_like==5 || 
   weather_like==6 || 
   weather_like==7 || 
   weather_like==8 || 
   weather_like==9 || 
   weather_like==10
   ) {
      wlike = "rain-snow";
   } 
   
   else if (
   weather_like==11 || 
   weather_like==12
   ) {
      wlike = "rain";
   } 
   
   else if (
   weather_like==13 || 
   weather_like==14 || 
   weather_like==15 || 
   weather_like==16 || 
   weather_like==41 || 
   weather_like==42 || 
   weather_like==43 || 
   weather_like==46
   ) {
      wlike = "snow";
   } 
   
   else if (
   weather_like==17 || 
   weather_like==18 || 
   weather_like==35
   ) {
      wlike = "hail";
   }
   
   else if (
   weather_like==25 || 
   weather_like==26 || 
   weather_like==28 || 
   weather_like==30 || 
   weather_like==44
   ) {
      wlike = "cloud";
   } 
   
   else if (
   weather_like==27 || 
   weather_like==29
   ) {
      wlike = "cloud-night";
   } 
   
   else if (
   weather_like==31 ||
   weather_like==33
   ) {
      wlike = "clear-night";
   } 
   
   else if (
   weather_like==32 ||
   weather_like==34 ||
   weather_like==36
   ) {
      wlike = "sun";
   } 
   
   else if (
   weather_like==20 ||
   weather_like==21 ||
   weather_like==22
   ) {
      wlike = "fog";
   } 
   
   else if (
   weather_like==19 || 
   weather_like==23 || 
   weather_like==24
   ) {
      wlike = "wind";
   }
};

// Moment locale
moment.locale('hu');

$(document).ready(function() {
   $('.celsius').html(celsius);
   $('.wlike').html('<img src="'+_C.livesite+'/templates/hajdupress/images/weather/'+wlike+'.png" />');
   $('.time').html(moment().format('HH:mm'));
   $('.date').html(moment().format('YY.MM.DD.'));
   setInterval(function () {$('.time').html(moment().format('HH:mm'));}, 10000);
   
   $('.cikk-content a').attr('target', '_blank');
   $('.poll-answers').hide();
});
function show_search(){
    $('.search').css('display','block').hide().fadeIn(600);
}
function close_video_description(){
   $('.top-video-description-wrapper').fadeOut(800);
   $('.top-video-opener').hide().delay(800).fadeIn(600);
}
function open_video_description(){
   $('.top-video-opener').fadeOut(600);
   $('.top-video-description-wrapper').hide().delay(600).fadeIn(800);
}
function show_poll() {
   $('.poll-answers').fadeIn(800);
}
function vote (poll, answer) {
   $.ajax({
     type: "POST",
     url: _C.livesite+"/modules/szavazas/ajax.php",
     data: {secure : _C.secure, command : 'vote', answer : answer, poll : poll},
     dataType : 'html',
   }).done(function(data) {
      voted();
   });
}
function voted (){
   $('.vote-button').hide();
   $('.poll-answers').append('<div data-alert class="alert-box alert">Köszönjük a szavazatod!<a href="#" class="close">&times;</a></div>');
}

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
 console.log('statusChangeCallback');
 console.log(response);
 // The response object is returned with a status field that lets the
 // app know the current login status of the person.
 // Full docs on the response object can be found in the documentation
 // for FB.getLoginStatus().
 if (response.status === 'connected') {
   // Logged into your app and Facebook.
   testAPI();
 } else if (response.status === 'not_authorized') {
   // The person is logged into Facebook, but not your app.
   document.getElementById('status').innerHTML = 'Please log ' +
     'into this app.';
 } else {
   // The person is not logged into Facebook, so we're not sure if
   // they are logged into this app or not.
   document.getElementById('status').innerHTML = 'Please log ' +
     'into Facebook.';
 }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
 FB.getLoginStatus(function(response) {
   statusChangeCallback(response);
 });
}

window.fbAsyncInit = function() {
FB.init({
 appId      : '1481907372073178',
 cookie     : true,  // enable cookies to allow the server to access 
                     // the session
 xfbml      : true,  // parse social plugins on this page
 version    : 'v2.1' // use version 2.1
});

// Now that we've initialized the JavaScript SDK, we call 
// FB.getLoginStatus().  This function gets the state of the
// person visiting this page and can return one of three states to
// the callback you provide.  They can be:
//
// 1. Logged into your app ('connected')
// 2. Logged into Facebook, but not your app ('not_authorized')
// 3. Not logged into Facebook and can't tell if they are logged into
//    your app or not.
//
// These three cases are handled in the callback function.

/*
FB.getLoginStatus(function(response) {
 statusChangeCallback(response);
});
*/
};

// Load the SDK asynchronously
(function(d, s, id) {
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) return;
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/hu_HU/sdk.js";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
 console.log('Welcome!  Fetching your information.... ');
 FB.api('/me', function(response) {
   console.log(response);
   $.ajax({
     type: "POST",
     url: _C.livesite+"/modules/login/ajax.php",
     data: {secure : _C.secure, command : 'auth_facebook', facebook_id : response.id, email : response.email, first_name : response.first_name, last_name : response.last_name, birthday:response.birthday},
     dataType : 'html',
   }).done(function(data) {
      $('.fb-login').hide();
      location.reload();
   });
 });
}
 