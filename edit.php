<?php
session_start();
include 'dbh.php';
if (!isset($_SESSION['id'])) {
header("Location: index.php");
} 
include ('inc/header.php');
include 'functions.php';
?>
<body>

<div class="container">
    <div class="row">
      
      <div class="twelve columns">
         <h4>
           <form name="form" action="functions.php" method="POST">
          <span><input type="text" name="teamName" value="<?php echo $_SESSION['teamName'];?>"></span>
           
        <a id="iconEdit" style="display: inline;" href="team.php?teamId=<?php echo $_SESSION['teamId']?>">
          <i class="material-icons">reply</i></a>
        </a>   
        </h4>
  </div>
      <div class="twelve columns">
         
        <span id="datarow">
        <?php
        editTeam();
          ?>          
        </span>
      <input class="button-primary" name="updateTeam" type="submit" id="btnUpdate" value="Tallenna muutokset">
        </form>
      </div>
      </div>
   </div>
<?php include('inc/footer.php'); ?>