<!-- 
  PROGRAMMERS: Muhammad Zaman, Aryan Chandra   
  DATE: November 3, 2023
  COMMENTS: 
-->
<?php      
    session_start();//session is a way to store information (in variables) to be used across multiple pages.  
    session_destroy();  
    header("Location: index.php");//use for the redirection to some page  
?> 