<?php

// if name is not in the post data, exit
if (!isset($_POST["name"])) {
    
    header("Location: error.html");
    exit;
}

require_once('xmlHandler.php');

// create the chatroom xml file handler
$xmlh = new xmlHandler("chatroom.xml");
if (!$xmlh->fileExist()) {
    header("Location: error.html");
    exit;
}

// open the existing XML file
$xmlh->openFile();

// get the 'users' element
$users_element = $xmlh->getElement("users");

// create a 'user' element
$user_element = $xmlh->addElement($users_element, "user");


// add the user name
$xmlh->setAttribute($user_element, "name", $_POST["name"]);

// save the XML file
$xmlh->saveFile();

// set the name to the cookie
setcookie("name", $_POST["name"]);



//upload picture



move_uploaded_file($_FILES['picture']['tmp_name'], "pictures/" . $_FILES["picture"]["name"]);
    
$pictures = $xmlh->getElement("pictures");

$picture  = $xmlh->addElement($pictures, "picture");
$xmlh->setAttribute($picture, "name", $_POST["name"]);
$xmlh->setAttribute($picture, "path", "pictures/" . $_FILES["picture"]["name"]);

$xmlh->saveFile();
// Cookie done, redirect to client.php (to avoid reloading of page from the client)
header("Location: client.php");

?>
