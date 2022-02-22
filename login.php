<?php
$db = mysqli_connect('mars.cs.qc.cuny.edu' , 'haab5466' , '23505466' , 'haab5466') or die("could not connect to database" ) ;
$username = $_POST['username'] ; // user id
$password = $_POST['password']  ;

$errors = array() ;

if( empty($username)) {
    array_push($errors , "Username is required" ) ;
}
if( empty($password)) {
    array_push($errors , "Password is required" ) ;
}

if( count($errors) == 0 ) {
    $query = "Select * from users where login = '$username' AND password = '$password' limit 1" ;
    $results = mysqli_query($db , $query) ;

    if( mysqli_num_rows($results) == 1) {
        session_start();
        $query = "Select user_id from users where login = '$username' limit 1" ;
        $results = mysqli_query($db , $query) ;
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = mysqli_fetch_array($results)['user_id'] ;
        header('Location: linkShortener.php');
    }
    else {
        echo "Wrong username/password or account doesn't exist!" ;
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