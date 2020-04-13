<?php

require('includes/header.php');
require('includes/navbar.php');

?>

<section id="search">
  <div class="container">
    <form action="">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search for Movies/TV Shows!">
      </div>
    </form>
  </div>
</section>

<section id="results">

</section>

<script>
  $(function() {

    const username = '<?php echo $userLoggedIn; ?>';
    let timer;

    $(".form-control").keyup(function() {
      clearTimeout(timer);
      timer = setTimeout(function() {
        let val = $(".form-control").val();

        if (val != "") {
          $.post('ajax/getSearchResults.php', {
            term: val,
            username: username
          }, function(data) {
            $("#results").html(data);
          })
        } else {
          $("#results").html("");
        }

      }, 500);
    });

  });
</script>

<?php require('includes/footer.php'); ?>