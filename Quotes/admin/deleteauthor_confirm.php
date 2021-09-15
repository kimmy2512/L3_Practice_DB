<?php

// check user is logged on...
if (isset($_SESSION['admin'])) {

    $author_ID = $_REQUEST['ID'];

    $deleteauthor_sql = "SELECT * FROM `author` WHERE `Author_ID` =".$_REQUEST['ID'];
    $deleteauthor_query = mysqli_query($dbconnect, $deleteauthor_sql);
    $deleteauthor_rs=mysqli_fetch_assoc($deleteauthor_query);

    $full_name = $deleteauthor_rs['First']." ".$deleteauthor_rs['Middle']." ".$deleteauthor_rs['Last'];

    $author_quotes_sql="SELECT * FROM `quotes` WHERE `Author_ID` =".$_REQUEST['ID'];
    $author_quotes_query=mysqli_query($dbconnect, $author_quotes_sql);
    $author_quotes_rs = mysqli_fetch_assoc($author_quotes_query);
    $author_quotes_count = mysqli_num_rows($author_quotes_query);

    ?>

    <h2>Delete <?php echo $full_name; ?> - Confirm</h2>

    <p>Do you really want to delete <b><i><?php echo $full_name; ?></i></b>.</p>

    <?php

    if($author_quotes_count > 0) {

        ?>
<div class="error">
    There are <?php echo $author_quotes_count; ?>quotes associated with <?php echo $full_name ?> and those will also be removed from the database.
</div>

<?php

    }   // end check for quotes if

?>

<p>
    <a href="index.php?page=../admin/deletequote&ID=<?php echo $_REQUEST['ID'];?>">Yes, Delete it!</a> |
    <a href="index.php?page=../admin/author&authorID=<?php echo $_REQUEST['ID']; ?>">No, take me home</a>
</p>

<?php

}   // end user logged in if

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

}   // end user not logged in else

?>