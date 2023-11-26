const express = require('express');
const mysql = require('mysql');
const jwt = require('jsonwebtoken');
const cors = require('cors'); 
const path = require('path'); 
const bodyParser = require('body-parser');


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

app.use(bodyParser.json());

// Endpoint to authenticate users and generate API key for api_premium
app.post('/authenticate', (req, res) => {
  const { email, password } = req.body;

  if (!email || !password) {
    return res.status(400).json({ error: 'Missing email or password' });
  }

  // Assume you have a hashed password stored in the database
  const query = 'SELECT * FROM patientdet WHERE email = ? AND password = ?';
  pool.query(query, [email, password], (err, results) => {
    if (err) {
      console.error('Error querying database:', err);
      return res.status(500).json({ error: 'Internal Server Error' });
    }

    if (results.length === 0) {
      return res.status(401).json({ error: 'Incorrect email or password' });
    }

    const user = results[0];
    const { email, occupation } = user;

    if (occupation === 'api_premium') {
      // Generate a special API key for api_premium
      const premiumSecretKey = '13efc8df1c7f9dab24b20505c1ab42ab';
      const token = jwt.sign({ email, occupation }, premiumSecretKey, { expiresIn: '1h' });

      // Send the token as a JSON response
      return res.json({ token });
    } else {
      return res.status(403).json({ error: 'You do not have access as an API premium user' });
    }
  });
});

app.get('/api/data', (req, res) => {
  const query = 'SELECT * FROM  drugdet';

  // Execute the query
  pool.query(query, (err, results) => {
    if (err) {
      console.error('Error executing query:', err);
      res.status(500).json({ error: 'Internal Server Error' });
    } else {
      // Send the results as JSON
      res.json(results);
    }
  });
});

app.get('/api/drug/:id', (req, res) => {
  const drugId = req.params.id;
  const query = 'SELECT * FROM drugdet WHERE ID = ?';

  // Execute the query with the drug ID as a parameter
  pool.query(query, [drugId], (err, results) => {
    if (err) {
      console.error('Error executing query:', err);
      res.status(500).json({ error: 'Internal Server Error' });
    } else {
      // Check if a drug with the specified ID was found
      if (results.length === 0) {
        res.status(404).json({ error: 'Drug not found' });
      } else {
        // Send the drug information as JSON
        res.json(results[0]);
      }
    }
  });
});

app.get('/api/drugs-by-category/:category', (req, res) => {
  const category = req.params.category;
  const query = 'SELECT * FROM drugdet WHERE category = ?';

  pool.query(query, [category], (err, results) => {
    if (err) {
      console.error('Error executing query:', err);
      res.status(500).json({ error: 'Internal Server Error' });
    } else {
      if (results.length === 0) {
        res.status(404).json({ error: 'No drugs found in the specified category' });
      } else {
        res.json(results);
      }
    }
  });
});

app.use(bodyParser.json());

// Endpoint to get a list of all patients
app.get('/api/patients', (req, res) => {
  const query = 'SELECT * FROM patientdet WHERE occupation = "Patient"';

  pool.query(query, (error, results) => {
    if (error) {
      console.error('Error querying database:', error);
      res.status(500).json({ error: 'Internal Server Error' });
      return;
    }

    res.json({ patientdet: results });
  });
});


app.get('/api/patient/:identifier', (req, res) => {
  const identifier = req.params.identifier;
  const query = 'SELECT * FROM patientdet WHERE email = ? AND occupation ="Patient"';

  pool.query(query, [identifier, identifier], (error, results) => {
    if (error) {
      console.error('Error querying database:', error);
      res.status(500).json({ error: 'Internal Server Error' });
      return;
    }

    if (results.length === 0) {
      res.status(404).json({ error: 'User not found' });
      return;
    }

    res.json({ user: results[0] });
  });
});

app.get('/api/patients-by-gender/:gender', (req, res) => {
  const gender = req.params.gender;
  const query = 'SELECT * FROM patientdet WHERE gender = ? AND occupation ="Patient"';

  db.query(query, [gender], (error, results) => {
    if (error) {
      console.error('Error querying database:', error);
      res.status(500).json({ error: 'Internal Server Error' });
      return;
    }

    res.json({ patients: results });
  });
});



// Serve HTML file
app.use(express.static(path.join(__dirname, '/')));

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
