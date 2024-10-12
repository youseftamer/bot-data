<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>first section for subjects</title>
    <link rel="stylesheet" href="css2.css">
</head>

<body>
    <h1>first section for subjects</h1>
    <form method="post">
        <h2>Add Subject Details</h2>
        <input type="text" name="code" placeholder="Enter subject code" required>
        <input type="text" name="subject_name" placeholder="Enter subject name" required>
        <input type="text" name="subject_doctor" placeholder="Enter subject doctor" required>
        <button type="submit" name="add_subject">Add Subject</button>
    </form>

    <h2>Output</h2>
    <pre>
        <?php
        // Specify the file path where your JS object is stored
        $filePath = 'command.js';

        // Function to add subject details in the JS object format
        function addSubjectToJSFile($filePath, $code, $subjectName, $subjectDoctor)
        {
            if (file_exists($filePath)) {
                $contents = file($filePath); // Read file into an array of lines
                $insertPosition = null;

                // Find the position in the file where we can add new subject details
                foreach ($contents as $keyLine => $line) {
                    if (strpos($line, '// Add more subject codes as needed') !== false) {
                        $insertPosition = $keyLine;
                        break;
                    }
                }

                if ($insertPosition !== null) {
                    // Format the new subject data
                    $newSubject = "  $code: {\n    subjectName: \"$subjectName\",\n    subjectDoctor: \"$subjectDoctor\",\n  },\n";

                    // Insert new data before the comment
                    array_splice($contents, $insertPosition, 0, $newSubject);

                    // Write the modified contents back to the file
                    file_put_contents($filePath, implode('', $contents));

                    echo "Subject added successfully: \n";
                    echo htmlspecialchars($newSubject);
                } else {
                    echo "Could not find the correct place to add the new subject.\n";
                }
            } else {
                echo "File does not exist.\n";
            }
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subject'])) {
            $code = $_POST['code'];
            $subjectName = $_POST['subject_name'];
            $subjectDoctor = $_POST['subject_doctor'];
            addSubjectToJSFile($filePath, $code, $subjectName, $subjectDoctor);
        }
        ?>
    </pre>
</body>

</html>