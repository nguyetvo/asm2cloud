<!DOCTYPE html>
<html>

<head>
    <title>Insert data to PostgreSQL with php - creating a simple web application</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />

    <style>
        li {
            list-style: none;
        }

        #ul {
            text-align: center;
            margin-right: 6.5%;
        }

        body {
            background-color: #FA54F5;
            background-image: linear-gradient(62deg, #FA54F5 0%, #FDC3FD 100%);
        }
    </style>
</head>

<body>
    <div>
        <div id="menu-content">
            <!-- Navigation -->
            <label id="collapse" for="_1">
                <img id="menuphoto" src="images/menu.svg">
            </label>
            <input id="_1" type="checkbox" name="mycheckbox" />
            <ul id="mainmenu">
                <li class="submenu">
                    <a href="ConnectToDB.php" title="Store">View Database</a>
                </li>
                <li class="submenu">
                    <a href="InsertData.php" title="Insert">Insert</a>
                </li>
                <li class="submenu" id="logoset">
                    <a href="index.php">
                        <img id="logo" src="images/Sneaker_logo.svg" /> <br />
                        <img id="sneaker" src="images/logo_name.png" />
                    </a>
                </li>
                <li class="submenu">
                    <a href="UpdateData.php" title="Update">Update</a>
                </li>
                <li class="submenu">
                    <a href="DeleteData.php" title="Delete">Delete</a>
                </li>
            </ul>
            <br />

        </div>
        <ul id="ul">
            <form name="InsertData" action="InsertData.php" method="POST">
                <label>Store ID:</label>
                <li><input type="text" name="ToyID" /></li>
                <label>Accountant:</label>
                <li><input type="text" name="ToyName" /></li>
                <label>Revenue:</label>
                <li><input type="text" name="Price" /></li>
                <br>
                <button type="submit" class="btn btn-primary">Insert to Database</button>
            </form>
        </ul>

        <?php

        if (empty(getenv("DATABASE_URL"))) {
            echo '<p>The DB does not exist</p>';
            $pdo = new PDO('pgsql:host=localhost;port=5432;dbname=mydb', 'postgres', '123456');
        } else {

            $db = parse_url(getenv("DATABASE_URL"));
            $pdo = new PDO("pgsql:" . sprintf(
                "host=ec2-54-225-72-238.compute-1.amazonaws.com;port=5432;user=rxtdhfqtpxrhhs;password=6f6584dbda6217790c95fefe913f8c1697b8d1467b37b8c44a1ccfb62b66d7cf;dbname=d5dfoim75pqir4",
                $db["host"],
                $db["port"],
                $db["user"],
                $db["pass"],
                ltrim($db["path"], "/")
            ));
        }

        if ($pdo === false) {
            echo "ERROR: Could not connect Database";
        }

        //Khởi tạo Prepared Statement
        //$stmt = $pdo->prepare('INSERT INTO student (stuid, fname, email, classname) values (:id, :name, :email, :class)');

        //$stmt->bindParam(':id','SV03');
        //$stmt->bindParam(':name','Vo Thi Kim Nguyet');
        //$stmt->bindParam(':email', 'nguyetvtktcs19024@fpt.edu.vn');
        //$stmt->bindParam(':class', 'GCD018');
        //$stmt->execute();
        //$sql = "INSERT INTO student(stuid, fname, email, classname) VALUES('SV02', 'Nguyet Vo','nguyetvtk@fpt.edu.vn','TCS19024')";
        $sql = "INSERT INTO sneakertoy(toyid, tname, unitprice)"
            . " VALUES('$_POST[ToyID]','$_POST[ToyName]','$_POST[Price]')";
        $stmt = $pdo->prepare($sql);
        //$stmt->execute();
        if (is_null($_POST[ToyID])) {
            echo "ToyID must be not null";
        } else {
            if ($stmt->execute() == TRUE) {
                echo "Record inserted successfully.";
            } else {
                echo "Error inserting record: ";
            }
        }
        ?>
</body>

</html>