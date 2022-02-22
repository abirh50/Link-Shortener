<?php

//Login users
$db = mysqli_connect('mars.cs.qc.cuny.edu' , 'haab5466' , '23505466' , 'haab5466') or die("could not connect to database" ) ;
$first_name = $_POST['first_name'] ;
$last_name = $_POST['last_name'] ;
$login = $_POST['login'] ; // user id
$password = $_POST['password']  ;

$errors = array() ;

if( empty($first_name)) {
    array_push($errors , "First name is required" ) ;
}
if( empty($last_name)) {
    array_push($errors , "Last name is required" ) ;
}
if( empty($login)) {
    array_push($errors , "Username is required" ) ;
}
if( empty($password)) {
    array_push($errors , "Password is required" ) ;
}
if( count($errors) == 0 ) {
    $query = "Select * from users where login = '$login'" ;
    // $query = "Select * from users where UserEmail = '$email' AND UserPassword = '$password' " ;
    $results = mysqli_query($db , $query) ;

    if( mysqli_num_rows($results) ) {
        echo 'The username already exists! Please choose another one.' ;
    }
    else {
        $query = "Insert into users (first_name, last_name, login, password ) values ( '$first_name' , '$last_name' , '$login' , '$password' )";
        mysqli_query($db, $query);
        $query = "Select * from users where login = '$login' ";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results)) {
            $_SESSION['user_id'] = mysqli_fetch_array($results)['user_id'];
            $_SESSION['login'] = mysqli_fetch_array($results)['login'];
            session_start() ;
            header("Location: register.html");
            echo 'You are now registered and logged in!';
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