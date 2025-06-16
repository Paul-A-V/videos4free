// mobile menu
var menu = document.getElementById('menu');
var mmenu = document.getElementById('mobile_menu');
var close = document.getElementById('Close');
menu.addEventListener('click', function () {
  mmenu.style.display = "block";
});
close.addEventListener('click', function () {
  mmenu.style.display = "none";
})

var list = document.querySelectorAll('li a');
for (el of list) {
  el.addEventListener("click", function () {
    mmenu.style.display = "none";
  })
}


// slider for general featured videos
var generalSlideVideos = document.getElementById("general_featured_videos") ? document.getElementById("general_featured_videos").getElementsByClassName("slide") : [];
var generalCounter = 0;

// slider for user uploads videos
var userUploadsSlideVideos = document.getElementById("user_uploads_videos") ? document.getElementById("user_uploads_videos").getElementsByClassName("slide") : [];
var userUploadsCounter = 0;

function hideAllVideos(videosArray) {
  for (var i = 0; i < videosArray.length; i++) {
    videosArray[i].style.display = "none";
  }
}

function slideshow(videosArray, counter) {
  hideAllVideos(videosArray);
  if (counter >= videosArray.length) {
    counter = 0;
  } else if (counter < 0) {
    counter = videosArray.length - 1;
  }
  videosArray[counter].style.display = "block";
  return counter; // Return the updated counter
}

function showNextVideo() {
  generalCounter = slideshow(generalSlideVideos, generalCounter + 1);
  userUploadsCounter = slideshow(userUploadsSlideVideos, userUploadsCounter + 1);
}

function showPreviousVideo() {
  generalCounter = slideshow(generalSlideVideos, generalCounter - 1);
  userUploadsCounter = slideshow(userUploadsSlideVideos, userUploadsCounter - 1);
}

// Initial display
window.onload = function () {
  if (generalSlideVideos.length > 0) {
    generalSlideVideos[generalCounter].style.display = "block";
  }
  if (userUploadsSlideVideos.length > 0) {
    userUploadsSlideVideos[userUploadsCounter].style.display = "block";
  }
};


document.getElementById("next").addEventListener("click", showNextVideo);
document.getElementById("previous").addEventListener("click", showPreviousVideo);

// used by add.php
function showFields() {
  var type = document.getElementById('type').value;
  document.getElementById('featured_fields').style.display = type === 'featured_videos' ? 'block' : 'none';
  document.getElementById('movie_fields').style.display = type === 'movies' ? 'block' : 'none';
  document.getElementById('tv_series_fields').style.display = type === 'tv_series' ? 'block' : 'none';
}