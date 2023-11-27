/*jshint esversion: 6 */
/*jshint node: true */
"use strict";

require('dotenv').config();

const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const io = require('socket.io').listen(server);
const listner = server.listen(process.env.PORT, function() {
	console.log('Listening on', listner.address().port);
});

require('./socket')(io);


app.use((req, res, next) => {
    res.header("Access-Control-Allow-Origin", "*");
    res.header(
        "Access-Control-Allow-Headers",
        "Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Request-Method"
    );
    res.header("Access-Control-Allow-Methods", "GET, POST, OPTIONS, PUT, DELETE");
    res.header("Allow", "GET, POST, OPTIONS, PUT, DELETE");
    next();
});

app.get('/', function (req, res) {
	res.send('Ok');
});