<?php

// get the name from cookie
$name = "";
if (isset($_COOKIE["name"])) {
    $name = $_COOKIE["name"];
}

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script language="javascript" type="text/javascript">
        //<![CDATA[
        var loadTimer = null;
        var request;
        var datasize;
        var lastMsgID;

        function load() {
            var username = document.getElementById("username");
           
            if (username.value == "") {
                loadTimer = setTimeout("load()", 100);
                return;
            }

            loadTimer = null;
            datasize = 0;
            lastMsgID = 0;


            
            var node = document.getElementById("chatroom");
            node.style.setProperty("visibility", "visible", null);

            getUpdate();
        }

        function unload() {
            var username = document.getElementById("username");
            if (username.value != "") {
                //request = new ActiveXObject("Microsoft.XMLHTTP");
                request =new XMLHttpRequest();
                request.open("POST", "logout.php", true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(null);
                username.value = "";
            }
            if (loadTimer != null) {
                loadTimer = null;
                clearTimeout("load()", 100);
            }
        }

        function getUpdate() {
            //request = new ActiveXObject("Microsoft.XMLHTTP");
            request =new XMLHttpRequest();
            request.onreadystatechange = stateChange;
            request.open("POST", "server.php", true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("datasize=" + datasize);
        }

        function stateChange() {
            if (request.readyState == 4 && request.status == 200 && request.responseText) {
                var xmlDoc;
                try {
                    xmlDoc =new XMLHttpRequest();
                    xmlDoc.loadXML(request.responseText);
                } catch (e) {
                    var parser = new DOMParser();
                    xmlDoc = parser.parseFromString(request.responseText, "text/xml");
                }
                datasize = request.responseText.length;
                console.log(xmlDoc);
                updateChat(xmlDoc);
                getUpdate();
            }
        }

        function updateChat(xmlDoc) {

            //point to the message nodes
            
            var messages = xmlDoc.getElementsByTagName("messages")[0];
        
            // create a string for the messages
	    /* Add your code here */
            //debugger;
            if(messages.childNodes.length > 0){
                
                var nameStr = messages.childNodes[lastMsgID].getAttribute("name");	
                var contentStr = messages.childNodes[lastMsgID].textContent;
                var color = messages.childNodes[lastMsgID].getAttribute("color");
                showMessage(nameStr, contentStr, color);
                lastMsgID++;
            }
        }
        
        
        
        function showMessage(nameStr, contentStr, color){
               
                
                
                
                var node = document.getElementById("chattext");
                
                // Create the name text span
                var nameNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");

                // Set the attributes and create the text
                nameNode.setAttribute("x", 100);
                nameNode.setAttribute("dy", 20);
                
                nameNode.appendChild(document.createTextNode(nameStr));

                // Add the name to the text node
                node.appendChild(nameNode);
                /*
                // Create the score text span
                var contentNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
                  
                // Set the attributes and create the text
                contentNode.setAttribute("x", 200);
                contentNode.setAttribute("fill", color);
                *
                */
                var plain_start =0;
                var link_start = 0;
                var plain = "";
                var link = "";
                
                var end = false;
                
                while(!end){
                    
                    
                    
                    link_start = contentStr.indexOf("http://", start=plain_start);
                    
                    console.log("link_start");
                    console.log(link_start);
                    
                    if(link_start == -1){
                        end = true;
                        link_start = contentStr.length;
                    }
                    
                    plain = " " + contentStr.substring(plain_start, link_start);
                    plain_node = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
                    plain_node.setAttribute("fill", color);
                    plain_node.appendChild(document.createTextNode(plain));
                    node.appendChild(plain_node);
                    
                    plain_start = contentStr.indexOf(" ", start=link_start);
                    
                    console.log("plain_start");
                    console.log(plain_start);
                    if(plain_start == -1){
                        
                        plain_start = contentStr.length;
                        
                    }
                    link = " " + contentStr.substring(link_start, plain_start);
                    
                    
                    if(link_start != contentStr.length){
                    //change to link here
                        link_node = document.createElementNS("http://www.w3.org/2000/svg", "a");
                       
                        link_node.setAttribute("href", link);
                        link_node.setAttribute("fill", color);
                        link_node.setAttribute("target", "_blank");
                        link_text = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
                        link_text.setAttribute("font-size", 12);
                        link_text.setAttribute("text-decoration", "underline");
                        link_text.appendChild(document.createTextNode(link));
                        link_node.appendChild(link_text);
                        node.appendChild(link_node);
                    }
            
            
            
                    
                }
                
                
                
                
                
                //contentNode.appendChild(document.createTextNode(contentStr));

                // Add the name to the text node
                //node.appendChild(contentNode);
        }

        //]]>
        </script>
    </head>

    <body style="text-align: left" onload="load()" onunload="unload()">
    <svg width="800px" height="2000px"
     xmlns="http://www.w3.org/2000/svg"
     xmlns:xhtml="http://www.w3.org/1999/xhtml"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     xmlns:a="http://www.adobe.com/svg10-extensions" a:timeline="independent"
     >

        <g id="chatroom" style="visibility:hidden">                
        <rect width="520" height="2000" style="fill:white;stroke:red;stroke-width:2"/>
        <text x="260" y="40" style="fill:red;font-size:30px;font-weight:bold;text-anchor:middle">Chat Window</text> 
        <text id="chattext" y="45" style="font-size: 20px;font-weight:bold"/>
      </g>
  </svg>
  
         <form action="">
            <input type="hidden" value="<?php print $name; ?>" id="username" />
        </form>

    </body>
</html>
