const express = require('express');
const app = express();
const port = 3000;

// Define a route for the homepage
app.get('/', (req, res) => {
  res.send('Hello, Node.js World!');
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
