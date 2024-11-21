<?php
// upload.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['medicalImage']) && $_FILES['medicalImage']['error'] == 0) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['medicalImage']['name']);
        $uploadFile = $uploadDir . $fileName;

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move uploaded file to the server
        if (move_uploaded_file($_FILES['medicalImage']['tmp_name'], $uploadFile)) {
            // Call the ML model for prediction (using a Python backend script)
            $command = escapeshellcmd("python3 predict.py " . escapeshellarg($uploadFile));
            $output = shell_exec($command);

            // Display result
            echo "<h2>Prediction Result:</h2>";
            echo "<p>$output</p>";
        } else {
            echo "<p>Error uploading the file. Please try again.</p>";
        }
    } else {
        echo "<p>No file uploaded or an error occurred. Please try again.</p>";
    }
}
?>
