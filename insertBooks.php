<?php
/*
plugin name: Insert Books
This page inserts book details
entered by the donor to the db 
*/

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . '/wp-load.php');
require_once('geolocator.php');
function insertBooks()
{
    if (isset($_POST['submit'])) {
        $inserReselts = "";
        $donorname = $_POST['donorname'];
        $category = $_POST['category'];
        $grade = $_POST['grade'];
        $bookname = $_POST['bookname'];
        $publishYr = $_POST['publishYr'];
        $comments = (strlen($_POST['comments']) > 300) ? substr($_POST['comments'], 0, 297) . '...' : $_POST['comments'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        //format the address for geocode lookup
        $address = str_replace(' ', '', $address);
        $result = getGeoCode($address);
        $latitude = $result['lat'];
        $longitude = $result['lng'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            global $wpdb;
            $sql = $wpdb->insert("bookInfo", array("donorName" => $donorname, "bookCategory" => $category, "grade" => $grade, "bookName" => $bookname, "publishYear" => $publishYr, "comments" => $comments, "email" => $email, "phone" => $phone));
            // echo $wpdb->show_errors();
            //echo $wpdb->print_error();
            // echo $wpdb->last_errors();
            if ($sql == true) {
                $inserReselts = 'Details Updated';
            } else {
                $inserReselts = 'Details could not be Updated , please contact Admin';
            }
            echo "<h3><br/><center>" . $inserReselts . "<br/><center></h3>";
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
                <h4>
                    <center>Instructions</center>
                </h4>
                <p>
                    <center>Please enter the below information. Requestors will not be able to see personal information such as your name, email ID, and phone number.An email will be sent out internally to you when they request any book.</center>
                </p>
                <p>
                    <label for="donorname">Donor Name</label>
                    <input type="text" placeholder="Donor Name (Optional)" name="donorname" id="donorname" align="left" />
                </p>
                <p>
                    <label for="category">Category</label>
                    <select name="category" id="category" required>
                        <option value="">Select Category </option>
                        <?php

                        $resultCategory = $wpdb->get_results("SELECT bookCategory FROM bookCategory");
                        foreach ($resultCategory as $row) {
                            $category = $row->bookCategory;
                            echo '<option value = ' . $category . '>' . $category . '</option>';
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="grade">Grade</label>
                    <select name="grade" id="grade" required>
                        <option value="">Select Grade</option>
                        <?php
                        $result_grade = $wpdb->get_results("SELECT grade FROM grade");
                        foreach ($result_grade as $row) {
                            $grade = $row->grade;
                            echo '<option value = ' . $grade . '>' . $grade . '</option>';
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="bookName">Book Name</label>
                    <input type="text" placeholder="Enter Book Name" name="bookname" id="bookname" align="left" required />
                </p>
                <p>
                    <label for="publishYr">Publish Year</label>
                    <input type="text" placeholder="Enter Publish Year(Optional)" name="publishYr" id="publishYr" align="left" />
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
                    <label for="address">Address</label>
                    <input type="text" placeholder="Enter Address (Optional)" name="address" id="address" align="left" />
                </p>
                <p>
                    <label for="comments">Comments</label>
                    <textarea id="comment" placeholder="Enter Book Details ((Optional, 300 Character Limit)" name="comments" cols="10" rows="2" align="left"></textarea>
                </p>


                <input id="submitBtn" type="submit" name="submit" value="Submit" />


            </fieldset>
        </form>
    </div>
<?php
}
add_shortcode('insertBooks', 'insertBooks');
?>