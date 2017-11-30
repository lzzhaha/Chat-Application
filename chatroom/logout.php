<?php 

require_once('xmlHandler.php');

if (!isset($_COOKIE["name"])) {
    header("Location: error.html");
    exit;
}

// create the chatroom xml file handler
$xmlh = new xmlHandler("chatroom.xml");
if (!$xmlh->fileExist()) {
    header("Location: error.html");
    exit;
}


$name = $_COOKIE["name"];

$xmlh->openFile();

$users = $xmlh->getElement("users");

$node_list = $users->childNodes;

foreach ($node_list as $node){
    
    if($xmlh->getAttribute($node, "name") == $name){
        
        $xmlh->removeElement($users, $node);
        
    }
    
}



$messages = $xmlh->getElement("messages");
$node_list = $messages->childNodes;

foreach($node_list as $node){
    
    if($xmlh->getAttribute($node, "name") == $name){
        
        $xmlh->removeElement($messages, $node);
    }
}

$pictures = $xmlh->getElement("pictures");
$node_list = $pictures->childNodes;

foreach($node_list as $node){
    
    if($xmlh->getAttribute($node, "name") == $name){
        
        $file = $xmlh->getAttribute($node, "path");
        
        unlink($file);
        
        $xmlh->removeElement($pictures, $node);
        
        
    }
}



$xmlh->saveFile();

header("Location: login.html")
?>
