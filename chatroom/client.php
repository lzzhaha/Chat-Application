<?php

if (!isset($_COOKIE["name"])) {
    header("Location: error.html");
    return;
}

// get the name from cookie
$name = $_COOKIE["name"];

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Add Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript">
        //<![CDATA[
        function load() {
            var name = "<?php print $name; ?>";

            //delete this line 
            //window.parent.frames["message"].document.getElementById("username").setAttribute("value", name)

            setTimeout("document.getElementById('msg').focus()",100);
        }
        
        function select(color){
            console.log(color);
            color_field = document.getElementById("color");
            color_field.value = color;
        }
        
        //]]>
        </script>
    </head>

    <body style="text-align: left" onload="load()">
        <form action="add_message.php" method="post">
            <table border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td>What is your message?</td>
                </tr>
                <tr>
                    <td><input class="text" type="text" name="message" id="msg" style= "width: 780px" /></td>
                </tr>
                <tr>
                    <td><input class="button" type="submit" value="Send Your Message" style="width: 200px" /></td>
                    
                </tr>
                <input type="hidden" name="color" id="color" value="red" />
                
            </table>
          
            
        </form>
        
   
        <div>Choose your color</div>
        <div style="background-color:red;left:0px;height:30px;width:100px" onclick="select('red')"></div>
            <div style="background-color:yellow;left:50px;height:30px;width:100px" onclick="select('yellow')"></div>
            <div style="background-color:green;left:100px;height:30px;width:100px" onclick="select('green')"></div>
            <div style="background-color:cyan;left:150px;height:30px;width:100px" onclick="select('cyan')"></div>
            <div style="background-color:blue;left:200px;height:30px;width:100px" onclick="select('blue')"></div>
            <div style="background-color:magenta;left:250px;height:30px;width:100px" onclick="select('magenta')"></div>
        <!--logout button-->
        
        
        
        <input class="button" type="submit" value="Show Online User List"  style="width: 400px" onclick="window.open('userList.php')"></input>
        
         <form action="logout.php" method="post">
            <input class="button" type="submit" value="log out"  style="width: 200px"></input>
        </form>
    </body>
</html>
