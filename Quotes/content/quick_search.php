<?php

$quick_find = mysqli_real_escape_string($dbconnect, $_POST['quick_search']);

// FInd subject ID
$subject_sql = "SELECT * FROM `subject` WHERE `Subject` LIKE '%$quick_find%'";
$subject_query = mysqli_query($dbconnect, $subject_sql);
$subject_rs = mysqli_fetch_assoc($subject_query);

$subject_count = mysqli_num_rows($subject_query);

if ($subject_count > 0) {
    $subject_ID = $subject_rs['Subject_ID'];
}

else
{
    // If this is not set query below breaks!
    // If it is set to zero, any quote which has less than three subjects will be displayed
    $subject_ID = "-1";
}

$find_sql = "SELECT * FROM `quotes`
JOIN author ON (`author`.`Author_ID` = `quotes`.`Author_ID`) 
WHERE `Last` LIKE '%$quick_find%' 
OR `First` LIKE '%$quick_find%'
OR `Subject1_ID` = $subject_ID
OR `Subject2_ID` = $subject_ID
OR `Subject3_ID` = $subject_ID
";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_query);

?>

<h2>Quick Search Results (Search Term: <?php echo $quick_find ?>)</h2>

<?php

if($count > 0) {

// Loop through results and display them...
do {

    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/', ' ', $find_rs['Quote']);

    include("get_author.php");

    ?>
<div class="results">
    <p>
        <?php echo $quote; ?><br />

        <!-- Display author name -->
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID'];?>">
            <?php echo $full_name; ?>
        </a>
    </p>

    <?php include("show_subjects.php"); ?>
</div>

<br />

<?php

}    // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query));
    }    // end if results exist if

else {
    // no results - display error

?>

<h2>Oops!</h2>

    <div class="error">
        Sorry - there are no quotes that match the search term <i><b><?php echo $quick_find ?></b></i>. Please try again.
    </div>

<p>&nbsp;</p>

<?php
}

?>