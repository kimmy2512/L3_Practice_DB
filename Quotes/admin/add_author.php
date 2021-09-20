<?php

// check user is logged on...
if (isset($_SESSION['admin'])) {

    // get country & occupation lists from database
    $all_countries_sql = "SELECT * FROM `country` ORDER BY `Birth_Country` ASC ";
    $all_countries = autocomplete_list($dbconnect, $all_countries_sql, 'Birth_Country');

    $all_occupations_sql = "SELECT * FROM `career` ORDER BY `Career` ASC ";
    $all_occupations = autocomplete_list($dbconnect, $all_occupations_sql, 'Career');

    // initialise author variables
    $first = "";
    $middle = "";
    $last = "";
    $yob = "";
    $gender_code = "";
    $gender = "";
    $country_1 = "";
    $country_2 = "";
    $occupation_1 = "";
    $occupation_2 = "";

    // Initialise country and occupation ID's
    $country_1_ID = $country_2_ID = $occupation_1_ID = $occupation_2_ID = 0;

    // set up error fields / visibility
    $last_error = $yob_error = $gender_error = $country_1_error = $occupation_1_error = "no-error";

    $last_field = $yob_field = $gender_field = "form-ok";
    $country_1_field = $occupation_1_field = "tag-ok";

    $has_errors = "no";

// Code velow executes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Get values from author part of form
        $first = mysqli_real_escape_string($dbconnect, $_POST['first']);
        $middle = mysqli_real_escape_string($dbconnect, $_POST['middle']);
        $last = mysqli_real_escape_string($dbconnect, $_POST['last']);
        $yob = mysqli_real_escape_string($dbconnect, $_POST['yob']);

        $gender_code = mysqli_real_escape_string($dbconnect, $_POST['gender']);
        if ($gender_code=="F") {
            $gender = "Female";
        }
        else if ($gender_code=="M") {
            $gender = "Male";
            }

        else {
            $gender = "";
        }

        $country_1 = mysqli_real_escape_string($dbconnect, $_POST['country1']);
        $country_2 = mysqli_real_escape_string($dbconnect, $_POST['country2']);
        $occupation_1 = mysqli_real_escape_string($dbconnect, $_POST['occupation1']);
        $occupation_2 = mysqli_real_escape_string($dbconnect, $_POST['occupation2']);

        // Error checking goes here

        // check last name is not blank
        if ($last == "") {
            $has_errors = "yes";
            $last_error = "error-text";
            $last_field = "form-error";
        }

        // if gender is not chosen...
        if ($gender == "") {
            $has_errors = "yes";
            $gender_error = "error-text";
            $gender_field = "form-error";
        }

        // check year of birth is valid

        $valid_yob = isValidYear($yob);

        if($yob < 0 or $valid_yob != 1 or !preg_match('/^\d{1,4}$/', $yob))
        {
        $has_errors = "yes";
        $yob_error = "error-text";
        $yob_field = "form-error";
        }

        // check that first country is not blank
        if($country_1 == "")       {
            $has_errors = "yes";
            $country_1_error = "error-text";
            $country_1_field = "form-error";
        }

        // check that first country is not blank
        if($occupation_1 == "")       {
            $has_errors = "yes";
            $occupation_1_error = "error-text";
            $occupation_1_field = "form-error";
            }

        // get country and occupation IDs
        $countryID_1 = get_ID($dbconnect, 'country', 'Country_ID', 'Birth_Country', $country_1);
        $countryID_2 = get_ID($dbconnect, 'country', 'Country_ID', 'Birth_Country', $country_2);
        $occupationID_1 = get_ID($dbconnect, 'career', 'Career_ID', 'Career', $occupation_1);
        $occupationID_2 = get_ID($dbconnect, 'career', 'Career_ID', 'Career', $occupation_2);

    if ($has_errors != "yes") {

        // add author to database
        $add_author_sql = "INSERT INTO `author` (`Author_ID`, `First`, `Middle`, `Last`, `Gender`, `Born`, `Country1_ID`, `Country2_ID`, `Career1_ID`, `Career2_ID`) VALUES (NULL, '$first', '$middle', '$last', '$gender_code', '$yob', '$countryID_1', '$countryID_2', '$occupationID_1', '$occupationID_2');";
        $add_author_query = mysqli_query($dbconnect, $add_author_sql);

        // Get Author ID
        $find_author_sql = "SELECT * FROM `author` WHERE `Last` = '$last'";
        $find_author_query = mysqli_query($dbconnect, $find_author_sql);
        $find_author_rs = mysqli_fetch_assoc($find_author_query);

        $new_authorID = $find_author_rs['Author_ID'];
        echo "New Author ID:".$new_authorID;

        $author_ID = $new_authorID;

    // Go to author page...
    header('Location: index.php?page=author&authorID='.$author_ID);

    }  // end add entry to database if

}   // end submit button if

}   // end if user logged in

else {

    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");

}   // end user not logged in else

?>

<h1>Add an Author...</h1>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_author");?>" enctype="multipart/form-data">

    <!-- Author's first name, optional -->
    <input class="add-field" type="text" name="first" value="<?php echo $first; ?>" placeholder="Author's First Name" />

    <br /><br />

    <input class="add-field" type="text" name="middle" value="<?php echo $middle; ?>" placeholder="Author's Middle Name (optional)" />

    <br /><br />

    <div class="<?php echo $last_error; ?>">
        Author's last name can't be blank
    </div>

    <input class="add-field <?php echo $last_field; ?>" type="text" name="last" value="<?php echo $last; ?>" placeholder="Author's Last Name" />

    <br /><br />

    <div class="<?php echo $gender_error; ?>">
        Please choose a gender...
    </div>
    <select class="adv gender <?php echo $gender_field; ?>" name="gender">

        <?php
        // selected option (so form holds user input)
        if($gender_code=="") {
            ?>
                <option value="" selected>Gender (Choose something)...
                </option>
        <?php

        }   // end gender not chose if

        else {
            ?>
                <option value="<?php echo $gender_code;?>" selected><?php echo $gender; ?></option>
        <?php

        }   // end gender chosen else

        ?>

        <option value="F">Female</option>
        <option value="M">Male</option>

    </select>

    <br /><br />

    <div class="<?php echo $yob_error; ?>">
        Please enter a valid year of birth (modern authors only).
    </div>

    <input class="add-field <?php echo $yob_field; ?>" type="next" name="yob" value="<?php echo $yob; ?>" placeholder="Author's year of birth" />

    <br /><br />

    <div class="<?php echo $country_1_error ?>">
        Please enter at least one country
    </div>

    <div class="autocomplete ">
        <input class="<?php echo $country_1_field; ?>" id="country1" type="next" name="country1" placeholder="Country 1 (Start Typing)...">
    </div>

    <br /><br />
    
    <div class="autocomplete ">
        <input id="country2" type="next" name="country2" placeholder="Country 2 (Start Typing)...">
    </div>

    <br /><br />

    <div class="<?php echo $occupation_1_error ?>">
        Please enter at least one country
    </div>

    <div class="autocomplete ">
        <input class="<?php echo $occupation_1_field; ?>" id="occupation1" type="next" name="occupation1" placeholder="Occupation 1 (Start Typing)...">
    </div>

    <br /><br />
    
    <div class="autocomplete ">
        <input id="occupation2" type="next" name="occupation2" placeholder="Occupation 2 (Start Typing)...">
    </div>

    <br/><br />


    <br/><br />

    <!-- Submit Button -->
    <p>
        <input class="add-field" type="submit" value="Submit" />
    </p>

</form>

<!-- Script to make autocomplete work -->
<script>
<?php include("autocomplete.php"); ?>

/* Arrays containing lists */

    var all_countries = <?php print("$all_countries"); ?>;
    autocomplete(document.getElementById("country1"), all_countries);
    autocomplete(document.getElementById("country2"), all_countries);

    var all_occupations = <?php print("$all_occupations"); ?>;
    autocomplete(document.getElementById("occupation1"), all_occupations);
    autocomplete(document.getElementById("occupation2"), all_occupations);

</script>