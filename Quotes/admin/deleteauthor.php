<?php

// check user is logged on...
if (isset($_SESSION['admin'])) {

    $author_ID = $_REQUEST['ID'];

    // Delete quotes
    $deletequote_sql = "DELETE FROM quotes WHERE `Author_ID` =".$_REQUEST['ID'];
    $deletequote_query = mysqli_query($dbconnect, $deletequote_sql);

    $delete_author_sql = "DELETE FROM `author` WHERE `author`.`Author_ID` =".$_REQUEST['ID'];
    $delete_author_query = mysqli_query($dbconnect, $delete_author_sql);

?>
<h1>Delete Success</h1>

<p>The author and associated quotes have been deleted</p>

<?php

}   // end user logged in if

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

}   // end user not logged in else

?>