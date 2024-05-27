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


// slider
var slideVideos = document.getElementsByClassName("slide");
var slideVideos_2 = document.getElementsByClassName("slide_2");
var counter1 = 0;
var counter2 = 0;

function hideAllVideos() {
  for (var i = 0; i < slideVideos.length; i++) {
    slideVideos[i].style.display = "none";
  }
}

function hideAllVideos_2() {
  for (var i = 0; i < slideVideos_2.length; i++) {
    slideVideos_2[i].style.display = "none";
  }
}

function slideshow() {
  hideAllVideos();
  if (counter1 > slideVideos.length - 1) {
    counter1 = 0;
  } else if (counter1 < 0) {
    counter1 = slideVideos.length - 1;
  }
  slideVideos[counter1].style.display = "block";
}

function slideshow_2() {
  hideAllVideos_2();
  if (counter2 > slideVideos_2.length - 1) {
    counter2 = 0;
  } else if (counter2 < 0) {
    counter2 = slideVideos_2.length - 1;
  }
  slideVideos_2[counter2].style.display = "block";
}

function showNextVideo() {
  counter1++;
  counter2++;
  slideshow();
  slideshow_2();
}

function showPreviousVideo() {
  counter1--;
  counter2--;
  slideshow();
  slideshow_2();
}

document.getElementById("next").addEventListener("click", showNextVideo);
document.getElementById("previous").addEventListener("click", showPreviousVideo);

// used by add.php
function showFields() {
  var type = document.getElementById('type').value;
  document.getElementById('featured_fields').style.display = type === 'featured_videos' ? 'block' : 'none';
  document.getElementById('movie_fields').style.display = type === 'movies' ? 'block' : 'none';
  document.getElementById('tv_series_fields').style.display = type === 'tv_series' ? 'block' : 'none';
}