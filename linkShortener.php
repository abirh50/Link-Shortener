<?php
    if(isset($_GET['id'])){
        $db = mysqli_connect('mars.cs.qc.cuny.edu' , 'haab5466' , '23505466' , 'haab5466') or die("could not connect to database" ) ;
        $id = $_GET['id'];
        $domain = "https://venus.cs.qc.cuny.edu/~haab5466/cs355/linkShortener.php/?id=";
        $url_link = $domain.$id;
        $query = "Select url_long from url where url_short = '$url_link' limit 1" ;
        //$url = mysqli_query($db , $query) ;
        $result = mysqli_query($db, $query);
        $row = $result->fetch_assoc();
        header('Location: ' . $row["url_long"]);

        $query = "UPDATE url SET hits = hits + 1 WHERE url_short = '$url_link' limit 1";
        if(mysqli_query($db , $query)) {
            $hit = $row["hits"] + 1;
        }
    }
    else {
        session_start();
        if ($_SESSION['loggedin'] != true) {
            header("Location: login.html");
        }

        if (array_key_exists('logout', $_POST)) {
            $_SESSION['loggedin'] = false;
            header("Location: index.html");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <title>Link Shortener Page</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
     h1{
        padding-top: 20%;
        color: #f9f9f9;
        text-align: center;
     }
     p{
        color: #f9f9f9;
     }
  </style>
</head>
<body>
   <!-- NAVBAR BEGINS HERE-->
   <nav id="navbar">
     <ul>
       <li class="dropdown">
         <a href="index.html" class="dropbtn">Home</a>
         <div class ="dropdown-content">
         </div>
       </li>
       <li class="dropdown">
         <a href="#" class="dropbtn">Course</a>
         <div class="dropdown-content">
           <a href="https://tophat.com/" target="_blank">TopHat</a>
           <a href="https://tinyurl.com/CSCI355-Summer2021" target="_blank">Course Google Drive</a>
           <a href="https://www.w3schools.com/" target="_blank">W3Schools</a>
         </div>
       </li>
       <li class="dropdown">
         <a href="developer.html" class="dropbtn">About</a>
         <div class="dropdown-content">
           <a href="developer.html">About The Developer</a>
           <a href="contact.html">Contact</a>
         </div>
       </li>
       <li class="dropdown">
           <a href="linkShortener.php" class="dropbtn">Link Shortener</a>
           <div class="dropdown-content">
           </div>
       </li>
       <form method="POST">
           <div class="dropdown_btn">
                <button name="logout" type="submit" class="contact-form-btn">Logout</button>
           </div>
       </form>
      </ul>
   </nav>
   <!--NAVBAR ENDS HERE-->


   <div class="custom-body">
       <div class="wrapper">
           <form action="link.php" method = "POST" >
               <div class="search">
                   <input type="text" id="longtext" name="ltext" placeholder="Enter link here" required value="">
                   <button type="submit" id = "shorten" name = "shorten">Convert</button>
               </div>
               <div class="search">
                   <input type="text" id="aliastext" name="aliastext" placeholder="Enter alias here (optional)" value="">
               </div>
           </form>
           <form action="history.php">
               <div class="search">
                   <button type="submit" id = "history" name = "history">User History</button>
               </div>
           </form>
           <div id="result"></div>
       </div>
   </div>

   <script src=script.js></script>

</body>
</html>