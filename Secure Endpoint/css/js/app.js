const express = require('express');
const bodyParser = require('body-parser');
const { exec } = require('child_process');
const app = express();
const PORT = 3000;

app.use(bodyParser.json());

// Secure endpoint middleware
const authenticate = (req, res, next) => {
  // Implement your authentication logic here
  // For simplicity, I'll assume there's an API key in the request header
  const apiKey = req.headers['api-key'];
  if (apiKey && apiKey === 'your-secret-api-key') {
    next();
  } else {
    res.status(401).json({ error: 'Unauthorized' });
  }
};

// Secure endpoint to list all users
app.get('/api/users', authenticate, async (req, res) => {
  try {
    const phpScript = 'path/to/your/database.php';
    const command = `php ${phpScript} getAllUsers`;
    const users = await exec(command);
    res.json(JSON.parse(users.stdout));
  } catch (error) {
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// Secure endpoint to get user details by email
app.get('/api/users/:email', authenticate, async (req, res) => {
  try {
    const userEmail = req.params.email;
    const phpScript = 'path/to/your/database.php';
    const command = `php ${phpScript} getUserByEmail ${userEmail}`;
    const user = await exec(command);
    if (user.stdout === '') {
      res.status(404).json({ error: 'User not found' });
    } else {
      res.json(JSON.parse(user.stdout));
    }
  } catch (error) {
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// ... (previous code)

// Secure endpoint to list users by gender
app.get('/api/users/gender/:gender', authenticate, async (req, res) => {
  try {
    const userGender = req.params.gender;
    const phpScript = 'path/to/your/database.php';
    const command = `php ${phpScript} getUsersByGender ${userGender}`;
    const users = await exec(command);
    res.json(JSON.parse(users.stdout));
  } catch (error) {
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// Secure endpoint to list users who purchased a drug on a specific date
app.get('/api/users/purchases/date/:purchaseDate', authenticate, async (req, res) => {
  try {
    const purchaseDate = req.params.purchaseDate;
    const phpScript = 'path/to/your/database.php';
    const command = `php ${phpScript} getUsersByPurchaseDate ${purchaseDate}`;
    const users = await exec(command);
    res.json(JSON.parse(users.stdout));
  } catch (error) {
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// Secure endpoint to list users by last login time
app.get('/api/users/last-login', authenticate, async (req, res) => {
  try {
    const phpScript = 'path/to/your/database.php';
    const command = `php ${phpScript} getUsersByLastLogin`;
    const users = await exec(command);
    res.json(JSON.parse(users.stdout));
  } catch (error) {
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// ... (other endpoints)

// Handle 404 - Not Found
app.use((req, res) => {
  res.status(404).json({ error: 'Not Found' });
});

// Handle 500 - Internal Server Error
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).json({ error: 'Internal Server Error' });
});

// ... (previous code)



const formatMiddleware = (req, res, next) => {
  const acceptHeader = req.headers['accept'];
  if (acceptHeader && acceptHeader.includes('application/xml')) {
    req.requestedFormat = 'xml';
  } else {
    req.requestedFormat = 'json';
  }
  next();
};

app.use(formatMiddleware);

// Secure endpoint middleware using access token
const authenticateWithToken = (req, res, next) => {
  const accessToken = req.headers['authorization'];

  if (accessToken && accessToken.startsWith('Bearer ')) {
    // Extract the actual token (remove 'Bearer ' prefix)
    const token = accessToken.slice(7);

    // Verify the token (you should use a proper authentication library or service)
    // For simplicity, we assume a hardcoded token for demonstration purposes
    if (token === '') {
      next();
    } else {
      res.status(401).json({ error: 'Unauthorized - Invalid Token' });
    }
  } else {
    res.status(401).json({ error: 'Unauthorized - Missing or Malformed Token' });
  }
};

// Example secure endpoint using token-based authentication
app.get('/api/secure-endpoint', authenticateWithToken, (req, res) => {
  res.json({ message: 'Access granted to secure endpoint' });
});

// ... (previous code)

// Function to send a formatted response (JSON or XML)
function sendFormattedResponse(req, res, data) {
  if (req.requestedFormat === 'xml') {
    res.header('Content-Type', 'application/xml');
    // Implement logic to convert data to XML (you can use a library like xml2js)
    res.send('<users><user><name>John Doe</name></user></users>');
  } else {
    res.json(data);
  }
}

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});



