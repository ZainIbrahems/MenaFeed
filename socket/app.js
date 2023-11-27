/*jshint esversion: 6 */
/*jshint node: true */
"use strict";

require('dotenv').config();
var cors = require('cors');
const express = require('express');
const app = express();
app.use(cors());
const fs = require('fs');
const options = {
    key: fs.readFileSync(process.env.KEY_PATH),
    cert: fs.readFileSync(process.env.CERT_PATH)
};
const https = require('https').Server(options, app);
// const io = require('socket.io')(https);
const io = require("socket.io")(https, {
    cors: {
        origin: "*:*",
        methods: ["GET", "POST"],
        allowedHeaders: [],
        credentials: true
    }
});
const listner = https.listen(process.env.PORT, function () {
    console.log('Listening on ', listner.address().port);
});

//allow only the specified domain to connect
// io.set('origins', '*:*');

require('./socket')(io);

app.get('/', function (req, res) {
    res.send('Ok');
});
