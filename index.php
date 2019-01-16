<?php
    $servername = "localhost";
    $username = "user";
    $password = "password";
    $dbname = "Shopping";
    $data=array();
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, 0, '/path/to/mysql/socket');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT Checked, Item, Shop FROM List where display =1 order by Shop, Item";
    $result = $conn->query($sql);
    //Set width to work properly on a phone
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    //Start of main table to display data
    echo '<big>Listy McListface</big><br>';
    echo '<table border=1><tr><th>Ticked</th><th>Item</th><th>Shop</th></tr>';
    //Set up a post so that it can write ticks to the database
    echo '<form action="https://path/to/checks.php" method="POST">';
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr align=center><td>";
        //Show checked state based on database
        $checked = '';
        if($row['Checked'] == TRUE){
            $checked = 'checked';
        }
        $item=$row['Item'];
        //Checks go into an array with the name of the item so it can be matched
        echo '<input type="checkbox" value="'.$item.'" name="chk[]"'.$checked.'>';
        echo "</td><td>";
        echo $row['Item'];
        echo "</td><td>";
        echo $row['Shop'];
        echo "</td></tr>";
    }
    echo '</table>';
    echo '<input type="submit" value="Save Ticks"></form><br>';
    //Refresh
    echo '<form action ="https://path/to/index.php" method="GET">';
    echo '<input type="submit" value="Refresh">';
    echo '</form>';
    //New entry insert form
    echo '<form action="https://path/to/inserto.php">';
    echo 'Item <input type="text" name="Item">';
    //yes these could be in a table but for the moment not concerned having them static
    echo '<select name="Shop">';
    echo '<option value="Coles">Coles</option>';
    echo '<option value="Chemist">Chemist</option>';
    echo '<option value="BigW">BigW</option>';
    echo '<option value="Woolworths">Woolworths</option>';
    echo '<option value="Aldi">Aldi</option>';
    echo '<option value="Other">Other</option>';
    echo '</select><br>';
    echo '<input type="submit" value="Add item">';
    echo '</form>';
    //Remove the ticked items from the displayed list.
    echo '<form action ="https://path/to/remticked.php" method="POST">';
    echo 'Save ticks before removing<br>';
    echo '<input type="submit" value="Remove Ticked">';
    echo '</form>';
    $conn->close();
?>
