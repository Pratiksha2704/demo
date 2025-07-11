<?php
 session_start();
 if(!isset($_SESSION['userdata'])){
    header("location: ../");
 }
  $userdata = $_SESSION['userdata'];
  $groupsdata = $_SESSION['groupsdata'];

  if($_SESSION['userdata']['status']==0){
    $status = '<b style="color:red">Not voted</b>';
  }
  else{
    $status = '<b style="color:green">voted</b>';
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
<style>

body {
    background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLLNeQcHS2GnuzAv6Y8xlNTJTrU_ALmufTGi2ikdBckmHFYa09OOuxsebbLwnOjIiaNqM&usqp=CAU');
            background-size: 100%; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Do not repeat the background image */
        }

 #backbtn{
    padding: 5px;
    font-size: 15px;
    background-color: #3498db;
    color: white;
    border-radius: 5px;
    float: left;
    margin: 10px;
 }

 #logoutbtn{
    padding: 5px;
    font-size: 15px;
    background-color: #3498db;
    color: white;
    border-radius: 5px;
    float: right;
    margin: 10px;
 }
#Profile{
    width: 30%;
    padding: 20px;
    float: left;
}

#Group{
    width: 60%;
    padding: 20px;
    float: right;

}

#votebtn{
    padding: 5px;
    font-size: 15px;
    background-color: #3498db;
    color: white;
    border-radius: 5px;

}
#mainpanel{
    padding: 10px;
}
#headersection{
    padding: 10px;
}

#voted{
    padding: 5px;
    font-size: 15px;
    background-color: green;
    color: white;
    border-radius: 5px;
}

Img:hover{
    ms-transorm:scale(1.2,1.2);
    -webkit-transform: scale(1.2,1.2);
    transform: scale(1.2,1.2);
}




</style>

<div id="mainsection">
    <center>
<div id="headersection">
<a href="../"><button id="backbtn">Back</button></a>
<a href="logout.php"><button id="logoutbtn"> Logout</button></a>
    <h1>Online voting System<h1>
    </div>
   
    </center>
    <hr>
   
     
    <div  id="mainpanel" >
    <div id="Profile">
       <center><img src="../uploads/<?php echo $userdata['photo'] ?>" height="100" width="100"></center><br><br>
       <b>Name:</b><?php echo $userdata['name'] ?> <br><br>
       <b>mobile:</b><?php echo $userdata['mobile'] ?><br><br>
       <b>Address:</b><?php echo $userdata['address'] ?><br><br>
       <b>Status:</b><?php echo $status ?><br><br>
       

     </div>
        <div id="Group">
            <?php
            if($_SESSION['groupsdata']){
                for($i=0; $i<count($groupsdata); $i++){
                    ?>
                    <div>
                    <img  style="float: right"    src="../uploads/<?php echo $groupsdata[$i]['photo'] ?>" height="100" width="100">

                        <b>Group Name:</b><?php echo $groupsdata[$i]['name'] ?><br><br></br>
                        <b>votes: </b><?php echo $groupsdata[$i]['votes']?><br><br>
                        <form  action="../api/vote.php"  method="POST">
                        <input type="hidden" name="gvotes" value="<?php echo $groupsdata[$i]['votes'] ?>">
                            <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['id'] ?>">
                            <?php
                                  if($_SESSION['userdata']['status']==0){
                                    ?>
                            <input type="submit" name="votebtn" value="vote" id="votebtn">
                            <?php
                          }
                                  else{
                                    ?>
                                    <button disabled type="button" name="votebtn" value="vote" id="voted">voted</button>
                                    <?php
                                  }
                                  ?>
                        </form>
                    </div>
                
     
                    <hr>
                    <?php
                }

            }

            else{

            }

            ?>


        </div>

</div>


        
        
</body>
</html>