<?php
$db = mysqli_connect('mars.cs.qc.cuny.edu' , 'haab5466' , '23505466' , 'haab5466') or die("could not connect to database" ) ;

session_start();

$inputUrl= $_POST['ltext'] ; // input url
$longUrl = $_POST['otext'] ; // long url output
$shortUrl = $_POST['shortUrl'] ; // short url
$hit = $_POST['htext'] ; // hit count
$userId = $_SESSION['user_id'] ;

$errors = array() ;

if( empty($inputUrl)) {
    array_push($errors , "URL is required" ) ;
}

if( count($errors) == 0 ) {
    $query = "Select url_long, url_short, hits from url where (url_long = '$inputUrl' OR url_short = '$inputUrl') AND user_id = '$userId' limit 1" ;
    $results = mysqli_query($db , $query) ;


    // found long url in db
    if( mysqli_num_rows($results) == 1) {
        $row = $results->fetch_assoc();
        $longUrl = $row["url_long"];
        $shortUrl = $row["url_short"];
        $hit = $row["hits"];

        echo "<div class='clear'>
               <button onclick=clearAll()>Clear All</button>
           </div>
           <div class='urls-area'>
               <div class='title'>
                   <li>Original URL</li>
                   <li>Shorten URL</li>
                   <li>Hits</li>
               </div>
               <div class='data'>
                   <a href='$longUrl' target='_blank'>$longUrl</a>
                   <a href='$shortUrl' target='_blank'>$shortUrl</a>
                   <li>$hit</li>
               </div>
           </div>";
    }
    else{ // inserting new long url
        $query = "insert into url(url_long, url_short, user_id, hits) values ('$inputUrl', '$shortUrl', '$userId', 0) ";
        mysqli_query($db , $query) ;

        $query = "Select url_long, url_short, hits from url where (url_long = '$inputUrl' OR url_short = '$inputUrl') AND user_id = '$userId' limit 1" ;
        $results = mysqli_query($db , $query) ;


        // found long url in db
        if( mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            $longUrl = $row["url_long"];
            $shortUrl = $row["url_short"];
            $hit = $row["hits"];

            echo "<div class='clear'>
               <button onclick=clearAll()>Clear All</button>
           </div>
           <div class='urls-area'>
               <div class='title'>
                   <li>Original URL</li>
                   <li>Shorten URL</li>
                   <li>Hits</li>
               </div>
               <div class='data'>
                   <a href='$longUrl' target='_blank'>$longUrl</a>
                   <a href='$shortUrl' target='_blank'>$shortUrl</a>
                   <li>$hit</li>
               </div>
           </div>";
        }
        else{
            echo 'Query failed!!!';
        }
    }
    mysqli_close($db);
}
else {
    mysqli_close($db);
    echo '<div>';
    foreach($errors as $error) {
        echo '<p>' . $error . '</p>';
    }
    echo '</div>';
}