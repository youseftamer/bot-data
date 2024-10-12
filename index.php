<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto reply section</title>
    <link rel="stylesheet" href="css1.css">
</head>

<body>
    <h1>Auto reply section</h1>
    <form method="post">
        <h2>Add Key-Value</h2>
        <!-- No need for search term input -->
        <input type="text" name="key" placeholder="Enter key" required>
        <input type="text" name="value" placeholder="Enter value" required>
        <button type="submit" name="search_add">Add</button>
    </form>

    <h2>Output</h2>
    <pre>
        <?php
        // Specify the file path
        $filePath = 'command.js';

        // The fixed search term
        $searchTerm = 'hello';

        // Function to search for "hello" and add key-value pair at a specific location
        function searchAndAddToFile($filePath, $searchTerm, $key, $value)
        {
            if (file_exists($filePath)) {
                $contents = file($filePath); // Read file into an array of lines
                $found = false;

                foreach ($contents as $keyLine => $line) {
                    if (strpos($line, $searchTerm) !== false) { // Search for the fixed term "hello"
                        // Format the key-value pair
                        $newData = "$key: \"$value\",";
                        // Insert new data on the next line
                        array_splice($contents, $keyLine + 1, 0, $newData . PHP_EOL);
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    file_put_contents($filePath, implode('', $contents)); // Write the modified contents back to the file
                    echo "Key-value pair added successfully after '$searchTerm'.\n";
                } else {
                    echo "Search term '$searchTerm' not found in the file.\n";
                }
            } else {
                echo "File does not exist.\n";
            }
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_add'])) {
            $key = $_POST['key'];
            $value = $_POST['value'];
            searchAndAddToFile($filePath, $searchTerm, $key, $value);
        }
        ?>
    </pre>
</body>

</html>