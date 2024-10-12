<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>second section for subjects</title>
    <link rel="stylesheet" href="css3.css">
</head>

<body>
    <h1>second section for subjects</h1>
    <form method="post" enctype="multipart/form-data">
        <h2>Subject Information</h2>
        <input type="text" name="code" placeholder="Enter subject code" required>
        <input type="text" name="subject_name" placeholder="Enter subject name" required>
        <input type="text" name="subject_doctor" placeholder="Enter subject doctor" required>

        <h2>Upload PDFs</h2>
        <label>Upload Book PDF</label>
        <input type="file" name="doc_pdf"><br><br>

        <label>Upload Summary PDF</label>
        <input type="file" name="sum_pdf"><br><br>

        <h2>Additional Information</h2>
        <input type="text" name="vid_link" placeholder="Enter video link" required>
        <input type="text" name="time_message" placeholder="Enter lecture time" required>

        <button type="submit" name="add_subject">Add Subject</button>
    </form>

    <h2>Output</h2>
    <pre>
        <?php
        // Specify the directories for book and summary PDF files
        $bookDir = './book/';
        $sumDir = './sum/';
        $filePath = 'command.js';

        // Function to add subject details in the JS object format
        function addSubjectToJSFile($filePath, $bookPath, $sumPath, $code, $subjectName, $subjectDoctor, $vidLink, $timeMessage)
        {
            if (file_exists($filePath)) {
                $contents = file($filePath); // Read file into an array of lines
                $insertPosition = null;

                // Find the position in the file where we can add new subject details
                foreach ($contents as $keyLine => $line) {
                    if (strpos($line, '// Add more subject codes and their respective details') !== false) {
                        $insertPosition = $keyLine;
                        break;
                    }
                }

                if ($insertPosition !== null) {
                    // Format the new subject data
                    $newSubject = "  $code: {\n    subjectName: \"$subjectName\",\n    subjectDoctor: \"$subjectDoctor\",\n    docPdf: \"$bookPath\",\n    sumPdf: \"$sumPath\",\n    vidLink: \"$vidLink\",\n    timeMessage: \"$timeMessage\",\n  },\n";

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
            $vidLink = $_POST['vid_link'];
            $timeMessage = $_POST['time_message'];

            // Handle file uploads
            $docPdf = $_FILES['doc_pdf'];
            $sumPdf = $_FILES['sum_pdf'];

            // Define paths for the uploaded files
            $docPdfPath = $bookDir . basename($docPdf['name']);
            $sumPdfPath = $sumDir . basename($sumPdf['name']);

            // Ensure directories exist before uploading
            if (!is_dir($bookDir)) {
                mkdir($bookDir, 0777, true);
            }
            if (!is_dir($sumDir)) {
                mkdir($sumDir, 0777, true);
            }

            // Check if uploads are successful
            if (move_uploaded_file($docPdf['tmp_name'], $docPdfPath) && move_uploaded_file($sumPdf['tmp_name'], $sumPdfPath)) {
                addSubjectToJSFile($filePath, $docPdfPath, $sumPdfPath, $code, $subjectName, $subjectDoctor, $vidLink, $timeMessage);
            } else {
                echo "Failed to upload files.\n";
            }
        }
        ?>
    </pre>
</body>

</html>