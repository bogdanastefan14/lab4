<?php
  $activePage = "gallery";
  include "header.php";

  echo '<h2>Gallery</h2>';

  $photos = scandir('uploadedfiles');
  $photos = array_diff($photos, array('.', '..'));

  foreach($photos as $photo) {
	  echo '<a href="uploadedfiles/'.$photo.'">'.$photo.'</a><br>';
  }

  include "footer.php";
 ?>