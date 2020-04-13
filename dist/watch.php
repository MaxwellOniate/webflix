<?php

require('includes/header.php');

if (!isset($_GET['id'])) {
  ErrorMessage::show('No ID passed into page.');
}

$video = new Video($con, $_GET['id']);

$video->incrementViews();
$upNextVideo = VideoProvider::getUpNext($con, $video);

?>

<section id="video-player">

  <div class="video-controls up-next d-none">
    <div class="up-next-container">
      <h2>Up Next:</h2>
      <h3><?php echo $upNextVideo->getTitle(); ?></h3>
      <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>
      <button onclick="restartVideo()" class="d-inline-block"><i class="fas fa-redo"></i> Replay</button>
      <button onclick="playVideo(<?php echo $upNextVideo->getID(); ?>)" ; class="d-inline-block play-next">
        <i class="fas fa-play"></i> Next
      </button>
    </div>
  </div>

  <nav class="video-controls video-nav">
    <button onclick="back(<?php echo $video->getEntityID(); ?>)" class="back-btn">
      <i class="fas fa-arrow-left"></i> <span class='back-btn-text'>Back to Browse</span>
    </button>
  </nav>

  <video controls autoplay onended="showUpNext()">
    <source src="<?php echo $video->getFilePath(); ?>" type="video/mp4">
  </video>


</section>

<script>
  function back(entityID) {
    window.location.href = 'entity.php?id=' + entityID;
  }

  function startHideTimer() {
    let timeout = null;

    $(document).on('mousemove', function() {
      clearTimeout(timeout);
      $('.video-nav').fadeIn();
      timeout = setTimeout(function() {
        $('.video-nav').fadeOut();
      }, 2000);
    });
  }

  function initVideo(videoID, username) {
    startHideTimer();
    setStartTime(videoID, username);
    updateProgressTimer(videoID, username);
  }

  initVideo("<?php echo $video->getID(); ?>", "<?php echo $userLoggedIn; ?>");
</script>

<?php require('includes/footer.php'); ?>