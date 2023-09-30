<?php

// Get the file URL from the GET parameter
$file_url = $_GET['file'];

// Read the file contents into a string
$file_contents = file_get_contents($file_url);

// Encode the file contents for use in JavaScript
$file_contents_js = json_encode($file_contents);

?>

<!-- Add a link to the Syntax.js stylesheet -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/syntax.js@latest/dist/syntax.css">

<!-- Add a link to the Syntax.js script -->
<script src="https://cdn.jsdelivr.net/npm/syntax.js@latest/dist/syntax.js"></script>

<!-- Add a button to toggle dark mode -->
<button id="dark-mode-button">Toggle Dark Mode</button>

<!-- Add a div to display the file contents -->
<div id="file-display"></div>

<!-- Add a script to handle the dark mode toggle and display the file contents with syntax highlighting and line numbering -->
<script>
  // Get the dark mode button and file display div
  const darkModeButton = document.getElementById("dark-mode-button");
  const fileDisplay = document.getElementById("file-display");

  // Set the initial dark mode state
  let darkMode = false;

  // Add an event listener to the dark mode button
  darkModeButton.addEventListener("click", function() {
    // Toggle the dark mode state
    darkMode = !darkMode;

    // Update the body class based on the dark mode state
    if (darkMode) {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
  });

  // Add an event listener to the document
  document.addEventListener("keydown", function(event) {
    // Check for the "D" key
    if (event.key === "d") {
      // Toggle the dark mode state
      darkMode = !darkMode;

      // Update the body class based on the dark mode state
      if (darkMode) {
        document.body.classList.add("dark-mode");
      } else {
        document.body.classList.remove("dark-mode");
      }
    }
  });

  // Get the file contents from the PHP script
  const fileContents = <?php echo $file_contents_js; ?>;

  // Display the file contents with syntax highlighting and line numbering
  Syntax.highlight({
    fileContents: fileContents,
    language: "auto",
    lineNumbers: true,
    element: fileDisplay
  });
</script>

<!-- Add some basic styling for dark mode -->
<style>
  body.dark-mode {
    background-color: black;
    color: white;
  }

  /* Add some styling for the line numbers */
  .syntax-line-numbers {
    color: #666;
  }

  /* Add some styling for code blocks */
  .syntax-code {
    background-color: #444;
  }

  /* Add some styling for code block comments */
  .syntax-comment {
    color: #999;
  }

  /* Add some styling for code block keywords */
  .syntax-keyword {
    color: #3399ff;
  }

  /* Add some styling for code block strings */
  .syntax-string {
    color: #00cc00;
  }

  /* Add some styling for the dark mode button */
  #dark-mode-button {
    background-color: #333;
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
  }

  #dark-mode-button:hover {
    background-color: #666;
  }
</style>
