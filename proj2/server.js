const express = require('express');
const mysql = require('mysql');
const jwt = require('jsonwebtoken');
const cors = require('cors'); 
const path = require('path'); 

const app = express();
const PORT = 8080;

const secretKey = 'e8d0f848dbcba7ea2d56bb6915bea062';
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: null, // Your MySQL password
  database: 'patientdet',
  connectionLimit: 10,
});

app.use(express.json());
app.use(cors());

// Endpoint for generating an API token based on user email
app.post('/generate-token', async (req, res) => {
  try {
    const { email } = req.body;

    // Check if the email is not an empty string
    if (email.trim() === '') {
      return res.status(400).json({ error: 'Email cannot be empty' });
    }

    // Retrieve user details from the database
    pool.getConnection((err, connection) => {
      if (err) {
        console.error('Error connecting to MySQL:', err.message);
        return res.status(500).json({ error: 'Internal Server Error' });
      }

      connection.query('SELECT * FROM patientdet WHERE email = ?', [email], (err, user) => {
        connection.release(); // Release the connection

        if (err) {
          console.error('Error querying MySQL:', err.message);
          return res.status(500).json({ error: 'Internal Server Error' });
        }

        // Check if the user exists
        if (user.length === 0) {
          return res.status(404).json({ error: 'User not found' });
        }

        // Generate an API token for the user
        const token = jwt.sign(
          { username: user[0].username, category: user[0].category, email: user[0].email },
          secretKey,
          { expiresIn: '1h' }
        );

        res.json({ token });
      });
    });
  } catch (error) {
    console.error('Error generating token:', error.message);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// Endpoint for generating a general API token
// Endpoint for generating a general API token
app.post('/generate-general-token', (req, res) => {
  try {
    // Generate a token that expires in 1 hour
    const token = jwt.sign({}, secretKey, { expiresIn: '1h' });
    res.json({ token });
  } catch (error) {
    console.error('Error generating general token:', error.message);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});


// Serve HTML file
app.use(express.static(path.join(__dirname, '/')));

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
