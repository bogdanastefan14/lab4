<?php
  $activePage = "mybooks";
  include "header.php";
?>
<form>
  <input type="text" placeholder="Title" name="title">
  <input type="text" placeholder="Author" name="author">
  <button type="submit">Submit</button>
</form>

My Books List
<?php

$searchtitle = "";
$searchauthor = "";

if (isset($_GET) && !empty($_GET)) {
  if (isset($_GET['title'])) {
    $searchtitle = htmlentities(trim($_GET['title']));
  }
  if (isset($_GET['author'])) {
    $searchauthor = htmlentities(trim($_GET['author']));
  }
  $query = " select * from books where onloan is true";
  if ($searchtitle && !$searchauthor) { // Title search only
      $query = $query . " where title like '%" . $searchtitle . "%'";
  }
  if (!$searchtitle && $searchauthor) { // Author search only
      $query = $query . " where author like '%" . $searchauthor . "%'";
  }
  if ($searchtitle && $searchauthor) { // Title and Author search
      $query = $query . " where title like '%" . $searchtitle . "%' and author like '%" . $searchauthor . "%'"; // unfinished
  }
  $stmt = $db->prepare($query);
  $stmt->bind_result($bookid, $title, $onloan, $author, $duedate);
  $stmt->execute();

  echo '<table><thead><th>ID</th><th>Title</th><th>Author</th><th>On Loan</th><th>Reserve</th></thead><tbody>';
  while ($stmt->fetch()) {
    echo "<tr>";
    echo "<td>$bookid</td><td>$title</td><td>$author</td><td>$onloan</td>";
    echo '<td><a href="returnBook.php?bookid=' . urlencode($bookid) . '">Return</a></td>';
    echo "</tr>";
  }
  echo "</tbody></table>";


} else {
  $query = " select * from books where onloan is true";
  $stmt = $db->prepare($query);
  $stmt->bind_result($bookid, $title, $onloan, $author, $duedate);
  $stmt->execute();

  echo '<table><thead><th>ID</th><th>Title</th><th>Author</th><th>On Loan</th><th>Reserve</th></thead><tbody>';
  while ($stmt->fetch()) {
    echo '<tr>';
    echo "<td>$bookid</td><td>$title</td><td>$author</td><td>$onloan</td>";
    echo '<td><a href="returnBook.php?bookid=' . urlencode($bookid) . '">Return</a></td>';
    echo '</tr>';
  }
  echo '</tbody></table>';
}
  include "footer.php";
?>