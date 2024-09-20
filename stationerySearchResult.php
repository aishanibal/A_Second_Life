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
    $category = $_GET['stationeryType'];


    //$rowIdArry = array();
    $rowId = 0;
    $results_per_page = 2;
    $sql = "select COUNT(*) as num_rows from stationeryInfo where stationeryType='$category'";
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
    $sql = "SELECT * FROM stationeryInfo where stationeryType='$category' LIMIT $this_page_first_result,$results_per_page";
    $result = $wpdb->get_results($sql);
    ?>
    <div class="ablock ">
        <h1> STATIONERY SEARCH RESULTS </h1>
        <table>
            <tr>
                <?php
                if ($number_of_results > 0) { ?>
                    <th colspan="5">Details</th>
                <?php } else {
                ?>
                    <th colspan="5"> No Stationery Found for this Category </th>
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
                                window.location.href = "https://asecondlife.me/wp-content/plugins/custom/contactDonorStationery.php?id=" + encodeURIComponent(<?php echo $id ?>);
                            }
                        </script>
                    </td>
                    <!-- Id-->
                    <td>
                        <center><label> Stationery Id:</label><br><?php echo $id; ?><center>
                    </td>
                    <!-- Book Name-->
                    <td><label>Stationery Type:</label><br><?php echo  $print->stationeryType; ?></td>
                    <!--Book Details With Donor name and other details-->
                    <td><label>Donor Name:</label><br><?php echo  $print->donorName; ?></td>
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
                echo '<a href="stationerySearchResult.php?page=' . $page . '&stationeryType=' . $category . '">' . $page . '</a> ';
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