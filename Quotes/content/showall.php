<h2>All Results</h2>

<?php

$find_sql = "SELECT * FROM `quotes`
JOIN author ON (`author`.`Author_ID` = `quotes`.`Author_ID`)
";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// Loop through results and display them...
do {

    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/', ' ', $find_rs['Quote']);

    // author name...
    $first = $find_rs['First'];
    $middle = $find_rs['Middle'];
    $last = $find_rs['Last'];

    $full_name = $first." ".$middle." ".$last;

    ?>
<div class="results">
    <p>
        <?php echo $quote; ?><br />
        <a href="index.php?page=author&authorID=<?php echo $find_rs['Author_ID'];?>">
            <?php echo $full_name; ?>
        </a>
    </p>

    <!-- Subject tags go here -->
    <p>
        <?php
            $sub1_ID = $find_rs['Subject1_ID'];
            $sub2_ID = $find_rs['Subject2_ID'];
            $sub3_ID = $find_rs['Subject3_ID'];

            $all_subjects = array($sub1_ID, $sub2_ID, $sub3_ID);

            // loop through subject ID's and look up the subject name
            foreach($all_subjects as $subject) {
                // get subject name
                $sub_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = $subject";
                $sub_query = mysqli_query($dbconnect, $sub_sql);
                $sub_rs = mysqli_fetch_assoc($sub_query);

                if($subject != 0)
                {


                ?>
            <-- show subjects -->
            <span class="tag">
                <a href="index.php?page=subject&subjectID=<?php echo $sub_rs['Subject_ID']; ?>">
                    <?php echo $sub_rs['Subject']; ?>
                </a>
            </span> &nbsp;

        <?php

            } // end subject exists if

            unset($subject);
                
            } // end subject loop

        ?>
    <p>
</div>

<br />

<?php

}    // end of display results 'do'

while($find_rs = mysqli_fetch_assoc($find_query))

?>