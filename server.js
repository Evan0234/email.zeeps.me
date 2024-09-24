const express = require('express');
const bodyParser = require('body-parser');
const fetch = require('node-fetch');
const app = express();
const port = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(express.static('public')); // Serve static files from 'public' directory

// Route to send the test email
app.post('/send-email', async (req, res) => {
    const { email } = req.body;

    try {
        const response = await fetch(`https://api.github.com/repos/Evan0234/email.zeeps.me/actions/workflows/send_test_email.yml/dispatches`, {
            method: 'POST',
            headers: {
                'Accept': 'application/vnd.github.v3+json',
                'Authorization': `Bearer ${process.env.EMAIL_TOKEN}`, // Use the environment variable for your PAT
            },
            body: JSON.stringify({
                ref: 'main', // Change to your default branch if necessary
                inputs: {
                    email: email,
                },
            }),
        });

        if (response.ok) {
            res.status(200).json({ message: 'Email sent successfully!' });
        } else {
            res.status(response.status).json({ message: 'Error sending email: ' + response.statusText });
        }
    } catch (error) {
        console.error('Error:', error);
        res.status(500).json({ message: 'Error sending email: ' + error.message });
    }
});

// Start the server
app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
