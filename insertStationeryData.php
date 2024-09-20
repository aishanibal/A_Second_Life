<?php
/*
plugin name: Insert Stationery Data
*/

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . '/wp-load.php');

function insertStationeryData()
{


    if (isset($_POST['submit'])) {
        //$_POST: Specific to input type only; gets info from input without displaying in URL
        //echo 'submitted';
        $insertResults = "";
        $donorname = $_POST['donorname'];
        $stationeryType = $_POST['stationeryType'];
        $comments = (strlen($_POST['comments']) > 300) ? substr($_POST['comments'], 0, 297) . '...' : $_POST['comments'];
        // ? is then     : is else     . is concat.
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        //echo $donorname;
        //echo $bookname;
        // Validate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            global $wpdb;

            $sql = $wpdb->insert("stationeryInfo", array("donorName" => $donorname, "stationeryType" => $stationeryType,  "comments" => $comments, "email" => $email, "phone" => $phone));
            //echo $wpdb->show_errors();
            //echo $wpdb->print_error();
            //echo $wpdb->last_errors();
            if ($sql == true) {
                $insertResults = 'Details Updated';
            } else {
                $insertResults = 'Details could not be Updated , please contact Admin';
            }

            echo "<h3><center>" . $insertResults . "<center></h3>";
        } //validate email
        else {
            echo ($email . " is not a valid email address");
        }
    } //submit
?>
    <style>
        <meta name="viewport"content="width=device-width, initial-scale=1.0>
<?php include "CSS/insertBooks.css" ?>
    </style>

    <?php
    global $wpdb;
    ?>
    <div class="container">
        <form action="" method="post">
            <fieldset>
                <br />
                <h3>
                    <center>Instructions</center>
                </h3>
                <p>
                    Please enter the below information. Requestors will not be able to see personal information such as your name, email ID, and phone number. An email will be sent out internally to you when they request any book.
                </p>
                <p>
                    <label for="donorname">Donor Name</label>
                    <input type="text" placeholder="Donor Name (Optional)" name="donorname" id="donorname" align="left" />
                </p>
                <p>
                    <label for="stationeryType">Stationery</label>
                    <select name="stationeryType" id="stationeryType" required>
                        <option value=""> Select Stationery</option>
                        <?php

                        $stationeryList = $wpdb->get_results("SELECT stationeryType FROM stationeryTypes");
                        foreach ($stationeryList as $row) {
                            $stationery = $row->stationeryType;
                            echo '<option value = ' . $stationery . '>' . $stationery . '</option>';
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="Email">Email</label>
                    <input type="text" placeholder="Enter Email ID" name="email" id="email" align="left" required />
                </p>
                <p>
                    <label for="phone">Phone</label>
                    <input type="text" placeholder="Enter Phone Number (Optional)" name="phone" id="phone" align="left" />
                </p>
                <p>
                    <label for="comments">Comments</label>
                    <textarea id="comment" placeholder="Enter Details (Optional, 300 Character Limit)" name="comments" cols="10" rows="2" align="left"></textarea>
                </p>


                <input id="submitBtn" type="submit" name="submit" value="Submit" />


            </fieldset>
        </form>
    </div>
<?php
}
add_shortcode('insertStationeryData', 'insertStationeryData');
?>