<?php

if(!isset($_REQUEST['subjectID']))
{
    header('Location: index.php');
}

$subject_to_find = $_REQUEST['subjectID'];

    // Get subject heading...
    $sub_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = $subject_to_find";
    $sub_query = mysqli_query($dbconnect, $sub_sql);
    $sub_rs = mysqli_fetch_assoc($sub_query);

?>

<h2>Subject Results <?php echo $sub_rs['Subject']?></h2>

<?php

// get quotes
$find_sql = "SELECT * FROM `quotes`
JOIN author ON (`author`.`Author_ID` = `quotes`.`Author_ID`) 
WHERE `Subject1_ID` LIKE $subject_to_find 
OR `Subject2_ID` = $subject_to_find 
OR `Subject3_ID` = $subject_to_find 
";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// Loop through results and display them...
do {

    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/', ' ', $find_rs['Quote']);

    // Get author name
    include("get_author.php");

    ?>

    <div class="results">
    <p>
        <?php echo $quote; ?><br />

        <!-- Display author name -->
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID']; ?>">
            <?php echo $full_name; ?>
        </a>
    </p>

</div>

    <?php

        }
    
        while($find_rs = mysqli_fetch_assoc($find_query));

        // include("show_subjects.php");

    ?>
