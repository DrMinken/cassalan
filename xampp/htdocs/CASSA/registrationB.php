<!-- //******************************************************

// Name of File: registration.php
// Revision: 1.0
// Date: 30/04/2012
// Author: Tinashe
// Modified: 5/05/2012

//***********************************************************

//*************** Start of REGISTRATION PAGE ******************* -->

<?php
session_start();
  if (!isset($_SESSION['username']))
{
    echo '<script type="text/javascript">history.back()</script>';
    die();
}
//get form data
$username = strip_tags( $_POST ['username']);
$submit = strip_tags( $_POST ['submit']);
$password = strip_tags ($_POST ['password']);
$repeatpassword = strip_tags($_POST ['repeatpassword']);
$first_name = strip_tags($_POST ['first_name']);
$last_name =strip_tags( $_POST ['last_name']);
$mobile = strip_tags($_POST ['mobile']);
$email = strip_tags($_POST ['email']);

if ($submit)
{
    //echo "$username/$password/$repeatpassword/$first_name/$last_name/$mobile/$email";
    // check for existance
    if($username&&$password&&$repeatpassword&&$first_name&&$last_name&&$mobile&&$email)
        {
   
            if($password == $repeatpassword)
            {
                // checking for first name and last name length 
                if ( strlen($first_name)>32 || strlen($last_name)>32)
                {
                    echo "Max limit for first name/ last name are 32 characters";
                }
    
                else
                {
                    //checking password length
                    if(strlen ($password)>64 || strlen($password)<6)
                    {
                        echo "Password must be between 6 and 64 characters long";
                    }
                    else
                    {
                        // registering the user
        
                        // encrypt the password
                        $password = md5($password);
                        $repeatpassword = md5($repeatpassword);
              
                        //open cassalan database
                        $connect = mysql_connect("localhost","reader","pass123");
                        //select database
                         mysql_select_db("cassa_lan");
                         // insert into database
                         $queryreg = mysql_query("
                         INSERT INTO client VALUES ('','$username','$password','$first_name','$last_name','$mobile','$email','')
                         ");
                         die("You have been succesfuly registered");
                          
                           //send activation email
                       //    $to = $email;
                         //   $subject = "Account Registration";
                           //  $headers = "From: cassa_team@gmail.com";
                             // $body = "Hello $username,\n\nYour Registration has been succesfull!";

                               //if (!mail($to,$subject,$body,$headers))
                                 //  echo "We couldn't sign you up at this time. Please try again later.";  
       
                    }
      $db->close(); //close database 
                }
        
            }    
    
      else
      echo "Your passwords do not match!";
  
    
    }
    else
    echo "Please fill in <b>all</b> fields!";
}

?>

