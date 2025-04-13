<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Web Systems Activity 1</title>
</head>
<body>
    <!-- First Name (Input Alphabets only)
    b. Last Name (Input Alphabets only)
    c. City Address (Input Alphabets only)
    d. Birthdate (Use Date Picker)
    e. Gender (Male, Female)
    f. Email (v -->
    <div class="form-container">
        <h1>Registration Form</h1>
        <form action="logic.php" method="POST">
            <input type="text" placeholder="First Name" id="fname" name="fname" required autocomplete="off"><br>

            <input type="text" placeholder="Last Name" id="lname" name="lname" required autocomplete="off"><br>

            <input type="text" placeholder="Address" id="address" name="address" required autocomplete="off"><br>
            <label for="selected_date">Birthdate:</label>
            <input type="date" id="selected_date" name="selected_date" required autocomplete="off"><br>
            
            <label>Gender:</label><br>
            <input type="radio" id="male" name="gender" value="Male" required autocomplete="off">
            <label for="male">Male</label>

            <input type="radio" id="female" name="gender" value="Female" required autocomplete="off">
            <label for="female">Female</label><br>

            <input type="text" placeholder="Email" id="email" name="email" required autocomplete="off"><br>

            <input type="submit" value="Submit">
            <input type="reset" value="Clear Form">
        </form>
    </div>
    <div class="form-container" style="margin-top: 10px;">
        <h1>Record</h1>
        <!-- <label for="sortBy">Sort By:</label>
        <input type="radio" id="sortBy" name="sortBy" value="first_name">
        <label for="sortBy">First Name</label>
        <input type="radio" id="sortBy" name="sortBy" value="last_name">
        <label for="sortBy">Last Name</label>
        <input type="radio" id="sortBy" name="sortBy" value="address">
        <label for="sortBy">Address</label> -->
        <h3>Sort by:</h3>
        <button><a href="?sort=first_name" style="text-decoration: none;">First Name</a></button>
        <button><a href="?sort=last_name" style="text-decoration: none;">Last Name</a></button>
        <button><a href="?sort=city_address" style="text-decoration: none;">Address</a></button>
        <br><br>
        <?php
        
        try 
        {
            $db = new PDO("sqlite:record.db");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //delete
            if (isset($_GET['delete_first'])) {
                $fnameToDelete = $_GET['delete_first'];
                $stmt = $db->prepare("DELETE FROM customer WHERE first_name = :first_name");
                $stmt->bindParam(':first_name', $fnameToDelete);
                $stmt->execute();
                // echo "<p>Deleted records: " . htmlspecialchars($fnameToDelete) . "</p>";
            }
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
        }

        $allowed = ['first_name', 'last_name', 'city_address'];
        $sortColumn = 'first_name';

        if (isset($_GET['sort']) && in_array($_GET['sort'], $allowed)) {
            $sortColumn = $_GET['sort'];
        }

        $query = $db->query("SELECT rowid, * FROM customer ORDER BY $sortColumn COLLATE NOCASE ASC");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table border='1' cellpadding='8' cellspacing='0'>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Address</th><th>Birthdate</th><th>Gender</th><th>Email</th><th>Action</th></tr>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['city_address']) . "</td>";
                echo "<td>" . htmlspecialchars($row['birthdate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td><a href='?delete_first=" . urlencode($row['first_name']) . "' onclick='return confirm(\"Delete this record?\")'><button>Delete Record</button></a></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No records found.";
        }
        ?>
    </div>
</body>

</html>