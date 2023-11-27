document.addEventListener('DOMContentLoaded', function () {
    // Fetch user data from the secure API endpoint and populate the All Users table
    fetch('/api/users', { headers: { 'api-key': 'your-secret-api-key' } })
      .then(response => response.json())
      .then(users => {
        const table = document.getElementById('usersTable');
        users.forEach(user => {
          const row = table.insertRow();
          const cell1 = row.insertCell(0);
          const cell2 = row.insertCell(1);
          cell1.textContent = user.firstName;
          cell2.textContent = user.lastName;
          // Add more cells as needed
        });
      })
      .catch(error => console.error('Error fetching user data:', error));
    
    // Fetch user data by gender
    fetch('/api/users/gender/male', { headers: { 'api-key': 'your-secret-api-key' } })
      .then(response => response.json())
      .then(users => {
        const table = document.getElementById('maleUsersTable');
        users.forEach(user => {
          const row = table.insertRow();
          const cell1 = row.insertCell(0);
          const cell2 = row.insertCell(1);
          cell1.textContent = user.firstName;
          cell2.textContent = user.lastName;
          // Add more cells as needed
        });
      })
      .catch(error => console.error('Error fetching male user data:', error));
  
    // Fetch user data by last login time
    fetch('/api/users/last-login', { headers: { 'api-key': 'your-secret-api-key' } })
      .then(response => response.json())
      .then(users => {
        const table = document.getElementById('lastLoginTable');
        users.forEach(user => {
          const row = table.insertRow();
          const cell1 = row.insertCell(0);
          const cell2 = row.insertCell(1);
          // Add more cells as needed
          cell1.textContent = user.firstName;
          cell2.textContent = user.lastName;
        });
      })
      .catch(error => console.error('Error fetching user data by last login time:', error));
  
    // Fetch user data by purchase date
    const specificDate = '2023-01-01'; // Replace with the specific date
    fetch(`/api/users/purchases/date/${specificDate}`, { headers: { 'api-key': 'your-secret-api-key' } })
      .then(response => response.json())
      .then(users => {
        const table = document.getElementById('purchaseDateTable');
        users.forEach(user => {
          const row = table.insertRow();
          const cell1 = row.insertCell(0);
          const cell2 = row.insertCell(1);
          // Add more cells as needed
          cell1.textContent = user.firstName;
          cell2.textContent = user.lastName;
        });
      })
      .catch(error => console.error(`Error fetching user data on ${specificDate}:`, error));
  });
  

   // Example: Access a secure endpoint with the generated token
   const accessToken = 'your-secret-access-token'; // Replace with the actual token
   fetch('/api/secure-endpoint', {
     headers: {
       'Authorization': `Bearer ${accessToken}`,
     },
   })
     .then(response => response.json())
     .then(data => {
       console.log('Secure Endpoint Response:', data.message);
     })
     .catch(error => console.error('Error accessing secure endpoint:', error));
 
  