<?php

if (!isset($_COOKIE["name"])) {
    header("Location: error.html");
    return;
}

// get the name from cookie
$name = $_COOKIE["name"];

// get the message content
$message = $_POST["message"];

$text_color = $_POST["color"];
if (trim($message) == "") $message = "__EMPTY__";

require_once('xmlHandler.php');

// create the chatroom xml file handler
$xmlh = new xmlHandler("chatroom.xml");
if (!$xmlh->fileExist()) {
    header("Location: error.html");
    exit;
}

// create the following DOM tree structure for a message
// and add it to the chatroom XML file
//
// <message name="...">...</message>
//


/* Add your code here */

$xmlh->openFile();

$messages_element = $xmlh->getElement("messages");
$message_element = $xmlh->addElement($messages_element, "message");

$xmlh->setAttribute($message_element, "name", $name);
$xmlh->addText($message_element, $message);
$xmlh->setAttribute($message_element, "color", $text_color);

$xmlh->saveFile();


header("Location: client.php");

?>
