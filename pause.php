<?php
// your_php_script.php

// Check if the 'id' parameter is set in the POST request
if(isset($_POST['id'])) {
    // Get the id parameter value
    $id = $_POST['id'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hama";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query using prepared statements
    $stmt = $conn->prepare("SELECT * FROM about WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if query was successful
    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         echo "ID: " . $row["id"]. " - isi: " . $row["isi"]. " - penanganan: " . $row["penanganan"]. " - pencegahan: " . $row["pencegahan"]. "";
    //     }
    if ($result->num_rows > 0) {
        // Mengambil satu baris data
        // $row = $result->fetch_assoc();
        $row = $result->fetch_assoc();
    
    // Menyimpan data dalam array
        $data[] = array(
            "ID" => $row["id"],
            "isi" => $row["isi"],
            "penanganan" => $row["penanganan"],
            "pencegahan" => $row["pencegahan"]
        );

        echo json_encode($data);
        
        // Output data dari baris tersebut
        // echo "ID: " . $row["id"]. " - isi: " . $row["isi"]. " - penanganan: " . $row["penanganan"]. " - pencegahan: " . $row["pencegahan"]. "";
    } else {
        echo "0 results"; // No matching records found
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "No 'id' parameter provided"; // Inform if 'id' parameter is not set
}
?>
