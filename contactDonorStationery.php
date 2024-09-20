<?php

//require 'PHPMailer/PHPMailerAutoload.php';
//require 'Applications/XAMPP/xamppfiles/htdocs/webOne/wp-content/plugins/custom/PHPMailer/PHPMailerAutoload.php';

require('PHPMailer/PHPMailerAutoload.php');
$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . '/wp-load.php');
$id = $_GET['id'];
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Stationery Search Result</title>
  <style>
    <?php include "CSS/contactDoner.css" ?>
  </style>
</head>

<body>

  <center>
    <h1>REQUESTED STATIONERY </h1>

    <table border="1">
      <tr>
        <th>STATIONERY DETAILS</th>
      </tr>
      <!--Display Search results-->
      <?php
      global $wpdb;
      global $email;
      $query = "select * from stationeryInfo where id ='$id' ";
      //echo  $query;
      $result = $wpdb->get_results($query);

      //for each row in the table
      foreach ($result as $print) {
        $stationeryType = $print->stationeryType;
        $comments = $print->comments;
        $email=$print->email;
      ?>
        <tr>
        </tr>
        <!-- Book Name-->
        <tr>
          <td><h3>Stationery Type</h3><?php echo $stationeryType; ?></td>
        </tr>
        <!--Book Details With Donor name and other details-->
        <tr>
          <td><h3>Donor's Comments</h3><?php echo $comments; ?></td>
        </tr>
  </center>
<?php
      }/*for*/
?>
</table>


<!---Button contact User -->
<form action="" method="post">
  <fieldset>
    <h2>Enter your Info and click submit to request</h2>
    <p>
      <label for="requestorEmail">Your Email:</label>
      <input type="text" placeholder="Your Email to contact" name="requestorEmail" id="requestorEmail" required />
    </p>
    <p>
      <label class="textLabel" for="comments">Comments or Questions to the Donor:</label>
      <textarea id="comment" name="comments" placeholder="Enter any comments besides the above stationery info in 300 chars" name="comments" cols="20" rows="2"></textarea>
    </p>
    <input id="btn" class="button" type="submit" value="Send Request to Donor" />
    <input type="hidden" name="button_pressed" value="1" />
  </fieldset>


</form>

<?php
if (isset($_POST['button_pressed'])) {
  $requestorEmail = $_POST['requestorEmail'];
  $requestorComments = (strlen($_POST['comments']) > 300) ? substr($_POST['comments'],0,300).'...' : $_POST['comments'];
  //Email Body
  $body = "We have received a request from " . $requestorEmail . " for the below stationery" .
    "\r\n Stationery Type: " . $stationeryType .
    "\r\n Your Comments: " . $comments .
    "\r\n Requestor's Comments: " . $requestorComments .
    "\r\n Please connect with " . $requestorEmail;

  // Validate email
  if (filter_var($requestorEmail, FILTER_VALIDATE_EMAIL)) {
    echo ($requestorEmail . " is  a valid email address");

    $comments = $_POST['comments'];
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML();
    $mail->Username = "asecondlife012@gmail.com";
    $mail->Password = "ougnryqnhjznszpe";
    $mail->SetFrom("asecondlife012@gmail.com");
    $mail->Subject = "Stationery Request";
    $mail->Body = nl2br($body);
    $mail->AddAddress($email);

    if (!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      echo "<br>Message has been sent";
    }
  } else {
    echo ($requestorEmail . " is not a valid email address");
  }
}
?>

<form action="" method="post">

</form>

<!---Button to Send Email-->
<!---Button to Home-->
<form method="post" action="https://asecondlife.me/">
  
  <center><input type="submit" name="submit" value="Home" align="right" /> </center>
</form>
</body>