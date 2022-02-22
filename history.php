<?php
$db = mysqli_connect('mars.cs.qc.cuny.edu' , 'haab5466' , '23505466' , 'haab5466') or die("could not connect to database" ) ;

session_start();

$userId = $_SESSION['user_id']; // user id

$errors = array() ;

if( empty($userId)) {
    array_push($errors , "User not logged in!!!" ) ;
}

if( count($errors) == 0 ) {
    $query = "Select url_long, url_short, date_created, hits from url where user_id = '$userId'" ;
    $results = mysqli_query($db , $query) ;

    // found rows in query
    if( mysqli_num_rows($results) > 0) {
        while($row = $results->fetch_assoc()){
            $longUrl[] = $row["url_long"];
            $shortUrl[] = $row["url_short"];
            $date[] = $row["date_created"];
            $hit[] = $row["hits"];
        }

        echo "<div class='clear'>
               <button onclick=clearAll()>Clear All</button>
           </div>
           <div class='urls-area2'>
               <div class='title'>
                   <li>Original URL</li>
                   <li>Shorten URL</li>
                   <li>Date Created</li>
                   <li>Hits</li>
               </div>";
        for($i=0; $i < count($longUrl); $i++) {
            echo "<div class='data'>";
            echo "<a href='$longUrl[$i]' target='_blank'>" . $longUrl[$i] . "</a>";
            echo "<a href='$shortUrl[$i]' target='_blank'>" . $shortUrl[$i] . "</a>";
            echo "<li>" . $date[$i] . "</li>";
            echo "<li>" . $hit[$i] . "</li>";
            echo "</div>";
        }
           echo "</div>";
    }
    else{
        echo "<div class='clear'>
               <button onclick=clearAll()>Clear All</button>
           </div>
           <div class='urls-area'>
               <li>No results found, you have never used URL shortener.</li>
           </div>";
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
