<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>General Token Generator</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      text-align: center;
    }

    button {
      margin-top: 20px;
      padding: 10px 15px;
      font-size: 16px;
      cursor: pointer;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 5px;
    }

    button:hover {
      background-color: #45a049;
    }

    #generalToken {
      margin-top: 20px;
      font-size: 18px;
    }

    #copyButton {
      margin-top: 10px;
      padding: 5px 10px;
      font-size: 14px;
      cursor: pointer;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
    }

    #copyButton:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>General Token Generator</h1>
    <button onclick="generateGeneralToken()">Generate General Token</button>
    <p id="generalToken"></p>
    <button id="copyButton" onclick="copyToClipboardAndRedirect()">Copy Token</button>
  </div>

  <script>
    function generateGeneralToken() {
      fetch('http://localhost:8080/generate-general-token', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(result => {
        const tokenElement = document.getElementById('generalToken');
        tokenElement.innerText = `Generated General Token: ${result.token}`;
        document.getElementById('copyButton').disabled = false; // Enable copy button
      })
      .catch(error => {
        console.error('Error generating general token:', error.message);
      });
    }

    function copyToClipboardAndRedirect() {
      copyToClipboard();
      // Redirect to api_products.html
      window.location.href = 'api_products.html';
    }

    function copyToClipboard() {
      const tokenElement = document.getElementById('generalToken');
      const textarea = document.createElement('textarea');
      textarea.value = tokenElement.innerText;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      document.body.removeChild(textarea);
      alert('Token copied to clipboard!');
    }
  </script>
</body>
</html>
