<?php

// check user is logged on...
if (isset($_SESSION['admin'])) {

    // get authors from database
    $all_authors_sql = "SELECT * FROM `author` ORDER BY `Last` ASC ";
    $all_authors_query = mysqli_query($dbconnect, $all_authors_sql);
    $all_authors_rs = mysqli_fetch_assoc($all_authors_query);

    // initialise author form
    $first = "";
    $middle = "";
    $last = "";

    // Code below executes when the form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values from form...
    $author_ID = mysqli_real_escape_string($dbconnect, $_POST['author']);
    $_SESSION['Add_Quote']=$author_ID;
    header('Location: index.php?page=../admin/add_entry');

    }    // end submit button pushed if

}   // end user logged in if

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

}   // end user not logged in else

?>

<h1>Add a Quote</h1>
<p><i>
    Instructions goes here... Click in the box below and start typing their <b>last</b> name.
</i><p>

<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/new_quote");?>">

    <div>
        <b>Quote Author:</b> &nbsp;

        <select name="author">
            <!-- Default option is new author -->
            <option value="unknown" selected>New Author</option>
            
            <?php

            do {

                // get authors full name (last, then first)
                $author_full = $all_authors_rs['Last'].",".$all_authors_rs['First']." ".$all_authors_rs['Middle'];

            ?>

            <option value="<?php echo $all_authors_rs['Author_ID']; ?>">
                <?php echo $author_full; ?>
            </option>

            <?php

            }  // end of author options 'do'

            while ($all_authors_rs=mysqli_fetch_assoc($all_authors_query))

            ?>

        </select>

        &nbsp;

        <input class="short" type="submit" name="quote_author" value="Next..." />

    </div>

</form>

&nbsp;