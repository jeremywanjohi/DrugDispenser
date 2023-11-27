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


app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
