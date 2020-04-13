$(document).scroll(function() {
  $('#main-nav').toggleClass(
    'scrolled',
    $(this).scrollTop() > $('#main-nav').height()
  );
});

const video = $('.preview-video');
const img = $('.preview-img');

$('.volume').click(function() {
  if (video.prop('muted')) {
    video.prop('muted', false);
  } else {
    video.prop('muted', true);
  }
});

function volumeToggle(button) {
  $(button)
    .find('i')
    .toggleClass('fa-volume-mute');
  $(button)
    .find('i')
    .toggleClass('fa-volume-up');
}

function previewEnded() {
  img.toggleClass('d-none');
  $('.volume').toggleClass('d-none');
  $('.replay').toggleClass('d-none');
  $('.preview-video').css('display', 'none');
}

function restartVideo() {
  $('video')[0].pause();
  $('video')[0].currentTime = 0;
  $('video')[0].play();
  $('.up-next').toggleClass('d-none');
}

$('.replay').click(function() {
  $('.replay').toggleClass('d-none');
  $('.volume').toggleClass('d-none');
  img.toggleClass('d-none');
  $('.preview-video').css('display', 'block');
  restartVideo();
});

// OWL CAROUSEL

$('.owl-carousel').owlCarousel({
  loop: true,
  margin: 5,
  nav: false,
  dots: false,
  responsiveClass: true,
  responsive: {
    0: {
      items: 1
    },
    400: {
      items: 2
    },
    600: {
      items: 3
    },
    900: {
      items: 4
    },
    1100: {
      items: 5
    },
    1400: {
      items: 6
    }
  }
});

// VIDEO PLAYER

function updateProgressTimer(videoID, username) {
  addDuration(videoID, username);

  let timer;

  $('video')
    .on('playing', function(e) {
      window.clearInterval(timer);
      timer = window.setInterval(function() {
        updateProgress(videoID, username, e.target.currentTime);
      }, 3000);
    })
    .on('ended', function() {
      setFinished(videoID, username);
      window.clearInterval(timer);
    });
}

function addDuration(videoID, username) {
  $.post(
    'ajax/addDuration.php',
    {
      videoID: videoID,
      username: username
    },
    function(data) {
      if (data !== null && data !== '') {
        alert(data);
      }
    }
  );
}

function updateProgress(videoID, username, progress) {
  $.post(
    'ajax/updateDuration.php',
    {
      videoID: videoID,
      username: username,
      progress: progress
    },
    function(data) {
      if (data !== null && data !== '') {
        alert(data);
      }
    }
  );
}

function setFinished(videoID, username) {
  $.post(
    'ajax/setFinished.php',
    {
      videoID: videoID,
      username: username
    },
    function(data) {
      if (data !== null && data !== '') {
        alert(data);
      }
    }
  );
}

function setStartTime(videoID, username) {
  $.post(
    'ajax/getProgress.php',
    {
      videoID: videoID,
      username: username
    },
    function(data) {
      if (isNaN(data)) {
        alert(data);
        return;
      }
      $('video').on('canplay', function() {
        this.currentTime = data;
        $('video').off('canplay');
      });
    }
  );
}

function showUpNext() {
  $('.up-next').toggleClass('d-none');
}

function playVideo(videoID) {
  window.location.href = 'watch.php?id=' + videoID;
}
