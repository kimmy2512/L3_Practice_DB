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

    header('Location: index.php?page=author&authorID='.$author_ID);

    }    // end submit button pushed if

    ?>

<h1>Admin Panel</h1>

<h2>Quotes...</h2>
<p>
    To <a href="index.php?page=../admin/new_quote">add a quote</a>, use the preceding link or the '+' symbol at the top right of the screen.
</p>
<p>
    Quotes can be efited / deleted by searching for a quote and then clicking on the 'edit' / 'delete' icons at the bottom right of each quote. If you don't see icos to edit / delete quotes, it means that you are logged out.
</p>

<hr />

<h2>Authors...</h2>

<p>Either <a href="index.php?page=../admin/add_author">Add an Author</a> or choose and author from the dropdown box below to edit / delete an existing author.</p>

<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/admin_panel");?>">
        
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
