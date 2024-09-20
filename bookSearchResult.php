<head>
    <meta charset="UTF-8">
    <title>Stationery Search Results</title>
    <style>
        <meta name="viewport"content="width=device-width, initial-scale=1.0>
<?php include "CSS/bookSearchResult.css" ?>
    </style>
</head>

<body>
    <?php
    //load the wordpress file which has the db info
    $path = preg_replace('/wp-content.*$/', '', __DIR__);
    require_once($path . '/wp-load.php');
    //the global wordpress db variable 
    global $wpdb;
    $category = $_GET['category'];
    $grade = $_GET['grade'];


    //$rowIdArry = array();
    $rowId = 0;
    $results_per_page = 2;
    $sql = "select COUNT(*) as num_rows from bookInfo where bookcategory='$category' and grade=$grade ";
    //echo $sql;
    $rows = $wpdb->get_results($sql);
    $number_of_results = $rows[0]->num_rows;
    // determine number of total pages available
    $number_of_pages = ceil($number_of_results / $results_per_page);
    //echo 'page'.$_GET['page'];
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    // determine the sql LIMIT starting number for the results on the displaying page
    $this_page_first_result = ($page - 1) * $results_per_page;

    //retrieve selected results from database and display them on page
    $sql = "SELECT * FROM bookInfo where bookcategory='$category' and grade='$grade' LIMIT $this_page_first_result,$results_per_page";
    $result = $wpdb->get_results($sql);
    ?>
    <div class="ablock ">
        <h1> BOOK SEARCH RESULTS </h1>
        <table>
            <tr>
                <?php
                if ($number_of_results > 0) { ?>
                    <th colspan="5">Book Details</th>
                <?php } else {
                ?>
                    <th colspan="5"> No Books Found for this Criteria </th>
                <?php  } ?>
            </tr>
            <?php
            foreach ($result as $print) {
                $rowId++;
            ?>
                <tr>
                    <?php $id = $print->id; ?>
                    <td>
                        <?php $ButtonId = "Btn" . $rowId; ?>
                        <button id=<?php echo $ButtonId; ?>>Request Donor</button>
                        <script>
                            var rowId = <?php echo $rowId ?>;
                            addButtonEventfunc();

                            function addButtonEventfunc() {
                                let btnIndex = "Btn" + rowId;
                                console.log(btnIndex);
                                document.getElementById(btnIndex).addEventListener("click", innerFunc);
                            }
                            function innerFunc() {
                                window.location.href = "https://asecondlife.me/wp-content/plugins/custom/contactDonor.php?id=" + encodeURIComponent(<?php echo $id ?>);
                            }
                        </script>
                    </td>
                    <!-- Id-->
                    <td>
                        <center><label> Book Id:</label><br><?php echo $id; ?><center>
                    </td>
                    <!-- Book Name-->
                    <td><label>Book Name:</label><br><?php echo  $print->bookName; ?></td>
                    <!--Book Details With Donor name and other details-->
                    <td><label>Donor Name:</label><br><?php echo  $print->donorName; ?></td>
                    <td><label>Published Year:</label><br><?php echo  $print->publishYear; ?></td>
                    <td><label>Comments:</label><br><?php echo  $print->comments; ?></td>
                </tr>
            <?php
            }/*for*/
            ?>
        </table>
    </div>
    <div class="navigation">
        <div class="pagination">
            <?php
            // display the links to the pages
            for ($page = 1; $page <= $number_of_pages; $page++) {
                echo '<a href="bookSearchResult.php?page=' . $page . '&category=' . $category . '&grade=' . $grade . '">' . $page . '</a> ';
            }
            ?>
</body>
</div>
</div>
<!---Button to Home-->
<form method="post" action="https://asecondlife.me/">
    </br>
    <center><input type="submit" name="submit" value="Home" align="right" /> </center>
</form>

</html>