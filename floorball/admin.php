<?php

?>

<!DOCTYPE html>
<html>
<head>

    </script>

        <script type="text/javascript">
        function disp_event_remove_confirm(){
            var name=confirm("Do you want to remove activity?")
            if (name==true){
                return true
            } else {
                return false
            }
        }


        function disp_event_copy_confirm(){
            var name=confirm("")
            if (name==true){
                return true
            } else {
                return false
            }
        }


        function disp_event_archive_confirm(){
            var name=confirm("Would you like to archive this activity? ")
            if (name==true){
                return true
            } else {
                return false
            }
        }

        function show_hide(tblid, show) {
            if (tbl = document.getElementById(tblid)) {
                if (null == show) show = tbl.style.display == 'none';
                    tbl.style.display = (show ? '' : 'none');
                }
        }

        function disp_add_person_information(){
            alert("Added group members will not be connected to activites/events. Use the change button for each event to add.")
        }


        function disp_help_information(){
            alert("Use categories (optional) if you have many group members and in an easy way would like to filter out for example team members when creating an activity. If you want you can name your own categories by clicking settings in the top menu.")
        }

    </script>

	<title>Welcome to Floorball</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<!-- <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'> -->
    <style type="text/css">
    .sidebar {
        float:center;
        width:200px;
        text-align: center;
    }
    .content {
        margin-left:auto;
    }
    </style>
</head>
<body>

    <div style="width:1000px; height:100%; background-color:#a0c0a0; text-align:center; margin:0 auto;">

	<?php if( !empty($user)):

        $email = $user['email'];
        $firstname = $user['firstname'];
        $lastname = $user['lastname'];

    ?>
        <p>
            <div class="header">
                You are logged in as <b> <?= $firstname, " ", $lastname ?></b> <a href="logout.php">Logout?</a>
            </div>
        </p> 
    <br />


    <br>
    <table width="750" class="Text"> 
    <tr>
    <td colspan=2 align="margin-left">To create a new activity, click here:</td></tr><tr>
    
    <td class="RowFooter" width=600>&nbsp;</td>
    <form method="POST" action='createEventMain.php' >
    <td class="RowFooter"align="right"><input class="TextButtonSmall" type="submit" value="New activity">
    </td> 
    </form>
    
    <form method="POST" action='eventArchive.php' >
    <td class="RowFooter" align="right"><input class="TextButtonSmall" type="submit" value="To archive">
    </td>
    </form>
     
    </tr>
    </table>

     
    <br>
     
    <table width="450" border="0" class="Text">
     <tr valign="top" align="center">
     <td>
     <b>Add group member</b><br>
     <table border="0" class="Text">
     <form method="POST"  action='groupInfo.php' >
        
            <tr>
            <td align="left">Firstname:</td>
            <td align="left"><input class="Input" type="text" size=15 name="firstname"></td>
            </tr>
            <tr>
            <td align="left">Lastname:</td>
            <td align="left"><input class="Input" type="text" size=15 name="lastname"></td>
            </tr>
            <tr>
            <td align="left">Email*:</td>
            <td align="left"><input class="Input" type="text" size=40 name="email"></td>
            </tr>
        
        <tr>
            <td align="left">Category:</td>
            <td align="left">
            <select name="category" class="Input">
            <option value=" "> </option>
            <option value="a"> A </option>
            <option value="b"> B </option>
            <option value="c"> C </option>
            <option value="d"> D </option>
            <option value="e"> E </option>
            <option value="f"> F </option>
            <option value="ab"> A,B </option>
            <option value="ac"> A,C </option>
            <option value="bc"> B,C </option>
            <option value="ad"> A,D </option>
            <option value="bd"> B,D </option>
            <option value="cd"> C,D </option>
            <option value="abc"> A,B,C </option>
        </select>
        <a class="Text" href="#a" onclick="disp_help_information()">Help</b></a>
        </td>
            </tr>               
        <tr>        
        <td/>       
        <td align="right">      
        <input type="submit" class="TextButtonSmall" name="newUser" value="Add new" ></td>
        </tr>
      </form>
      </table>
     </td>
     <td>
     <b>Add multiple group members</b><br>
     <table class="Text">
     <form method="POST"  action='groupInfo.php' >
            <tr>
            <td align="left"><textarea class="Input" name="multipleUsersString" rows="6" cols="35">Email addresses separated with semicolon (;)</textarea></td>
            </tr>
            <tr>
        <td align="right"><input type="submit" class="TextButtonSmall" name="newMultipleUser" value="Add multiple" ></td>
        </tr>   
        
      </form>
      </table>
      
     </td>
     </tr>
     </table>


    <br>
    <form method="POST" action='listMembers.php'>
    <table width="510" border="0" class="Text">
    <tr>
    <td align="center"><b>Member register</b></td>
    </tr><tr>
    <td align="center">Store more detailed information about your group members in the member register. The register can be exported to for example excel. Edit each user details by clicking the 'More...' buttons in the list below.</td>
    </tr><tr>
    <td align="center"><input type="submit" class="TextButtonSmall" value="Membership register"></td>
    </tr>
    </table>
    </form>

     
    <p><b><a class=Text>Group members in tinashe <a/></b></p> 

    <?php

    require 'databaseconn.php';

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $records = $conn->prepare('SELECT * FROM groupInfo ORDER BY firstname ASC');
    $records->execute();
    $users = $records->fetchAll();

    if (count($users) > 0):
    ?>
    <table class="Text" cellspacing="0">
    <tr>
    <th class='RowHeader' align="left">Firstname</th>
    <th class='RowHeader' align="left">Lastname</th>
    <th class='RowHeader' align="left">Email*</th>
    <th class='RowHeader' align="left" colspan='3'>Category:</th>
    </tr>

    <?php
    $groupEmails = "";

    foreach ($users as $user) {
        if (empty($groupEmails)):
            $groupEmails = $user['email'];
        else:
            $groupEmails = $groupEmails.";".$user['email'];
        endif;
    ?>     
     <tr>
        
        <form method="POST" action='groupInfo.php' >
        <tr>
        
            <td align="left"><input type="text" class="InputSmall" size=15 name="firstname" value=<?php echo $user['firstname'];?>></td>
            <td align="left"><input type="text" class="InputSmall" size=15 name="lastname" value=<?php echo $user['lastname'];?>></td>
            <td align="left"><input type="text" class="InputSmall" size=50 name="email" value=<?php echo $user['email'];?>></td>
        
        <td align="left">
            <select name="category" class="InputSmall">
            <option selected="selected"><?php echo $user['category'];?></option>
            <option value=" "> </option>
            <option value="a" > A </option>
            <option value="b" > B </option>
            <option value="c"  > C </option>
            <option value="d"  > D </option>
            <option value="e"  > E </option>
            <option value="f"  > F </option>
            <option value="ab" > A,B </option>
            <option value="ac" > A,C </option>
            <option value="bc" > B,C </option>
            <option value="ad" > A,D </option>
            <option value="bd" > B,D </option>
            <option value="cd" > C,D </option>
            <option value="abc" > A,B,C </option>
            </select>
        </td>
        

        <input type="hidden" name="userid" value=<?php echo $user['id'];?>>
                    

        <td align="right"><input type="submit" class="TextButtonSmall" name="updateUser" value="Update"></td>
        <td align="right"><input type="submit" class="TextButtonSmall" name="deleteUser" value="Remove"></td> 
        <!-- <td align="left"><input type="submit" class="TextButtonSmall" name="editUser" value="More"></td> -->      
        </tr>
        </form>
        </tr>
        <?php } ?>
        <tr><td class="RowFooter" colspan='7'>&nbsp;</td></tr>
        </table>
   <?php
   else:
   $message = "There are no members in this group";
   echo $message; 
   endif;
   $conn = NULL; 
   ?> 
        
        <br><a class="TextSmall" href="javascript:;" onclick="show_hide('addresses')">Get group mail addresses semicolon separated</a>
        <table id="addresses" style="display:none" class="Text" border="0">
         <tr>
         <td><textarea class="InputSmall" rows="4" cols="80" style="overflow: auto;"><?php echo $groupEmails;?></textarea></td>
         </tr>
        </table>
        
        

        <br>
        <div class="TextSmall">
        <form method="POST" action='groupInfo.jsp' >
            <b>*</b> Add more than one mail address per group member by semi-colon separating them, for example a@mail.se;b@mail.se<br>
            
            </form></div>
        
         
        <br>

        <table width="300" border="0">
        <tr>
        <td align="center"><a href='logout.php' class="Text">Log off</a></td>
        </tr>
        </table>
    			
    	<?php else: ?>

    		<h1>Please Login or Register</h1>
    		<a href="login.php">Login</a> or
    		<a href="register.php">Register</a>

    	<?php endif; ?>
    </div>
</body>
</html>