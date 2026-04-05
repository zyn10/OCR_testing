require('dotenv').config();
const express = require('express');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// Serve static files (CSS, JS, images)
app.use(express.static(__dirname));

// Route for index.html with API key injection
app.get('/', (req, res) => {
  let html = fs.readFileSync(path.join(__dirname, 'index.html'), 'utf8');
  
  // Inject the API key into the meta tag
  html = html.replace(
    /<meta name="gemini-api-key" content="[^"]*" \/>/,
    `<meta name="gemini-api-key" content="${process.env.GEMINI_API_KEY}" />`
  );
  
  res.send(html);
});

// Route for other HTML files
app.get('/:page.html', (req, res) => {
  const filePath = path.join(__dirname, `${req.params.page}.html`);
  if (fs.existsSync(filePath)) {
    let html = fs.readFileSync(filePath, 'utf8');
    
    // Inject the API key if this page has the meta tag
    html = html.replace(
      /<meta name="gemini-api-key" content="[^"]*" \/>/,
      `<meta name="gemini-api-key" content="${process.env.GEMINI_API_KEY}" />`
    );
    
    res.send(html);
  } else {
    res.status(404).send('Page not found');
  }
});

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
  console.log(`Gemini API Key loaded: ${process.env.GEMINI_API_KEY ? 'Yes' : 'No'}`);
});
