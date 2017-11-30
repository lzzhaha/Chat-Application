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
        <title>User List Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script language="javascript" type="text/javascript">
        //<![CDATA[
        var loadTimer = null;
        var request;
        var datasize;
        var lastUsrID;

        function load() {
            var username = document.getElementById("username");
           
            if (username.value == "") {
                loadTimer = setTimeout("load()", 100);
                return;
            }

            loadTimer = null;
            //datasize = 0;
            //lastUsrID = 0;


            
            //var node = document.getElementById("chatroom");
            //node.style.setProperty("visibility", "visible", null);

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
            request.open("POST", "list_handler.php", true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(null);
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
                //datasize = request.responseText.length;
                console.log(xmlDoc);
                updateList(xmlDoc);
                getUpdate();
            }
        }

        function updateList(xmlDoc) {

            //point to the message nodes
            var pictures = xmlDoc.getElementsByTagName("pictures")[0];
            console.log(pictures);
            debugger;
            // create a string for the messages
	    /* Add your code here */    
            //debugger;
            table = document.getElementById("user_list");
            console.log("table has " + table.childNodes.length);
           
            while(table.childNodes.length >3){
                
                table.removeChild(table.lastChild);
            }
            
            
            for(var i=0; i<pictures.childNodes.length; i++){
                
                picture = pictures.childNodes[i];
                var name = picture.getAttribute("name");
                var path = picture.getAttribute("path");
                
                showPicture(name, path);
                
            }
            
            
        }
        
        
        
        function showPicture(name, path){
            
            table = document.getElementById("user_list");
            
            var new_row = document.createElement("tr");
            
            var name_cell = document.createElement("td");
            name_cell.innerHTML = name;
            
            var img_cell = document.createElement("td");
            var img = document.createElement("img");
            img.src = path;
            
            img.style = "width:50px;height:50px";
            
            img_cell.appendChild(img);
            
            new_row.appendChild(img_cell);
            
            new_row.appendChild(name_cell);
            
            table.appendChild(new_row);
            
        }
                
                
                
                
      
        //]]>
        </script>
    </head>

    <body style="text-align: left" onload="load()" onunload="unload()">
    
        <form action="">
            <input type="hidden" value="<?php print $name; ?>" id="username" />
        </form>
        <table id="user_list" border="1">
            <col width="200">
            <col width="200">
            <tr>
                <td>
                   Picture
                </td>
                <td>
                    User name
                </td>
            </tr>
            
            
            
            
        </table>
    </body>
</html>
