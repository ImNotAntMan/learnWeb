<?php
if(isset($_POST['name'], $_POST['number']))
{ 
    $name = $_POST['name'];
    $number = $_POST['number'];
    echo "User Has submitted the form and entered this name : <b> $name </b>";
    echo "<br>$number You can use the following form again to enter a new name."; 
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="name"><br>
    <input type="text" name="number"><br>
   <input type="submit" name="submit" value="Submit Form"><br>
</form>