var https = require('https');
var fs = require('fs');
var express = require('express');
var options = {
    key: fs.readFileSync('/etc/ssl/private/kjora.key'),
    cert: fs.readFileSync('/etc/ssl/certs/ea341d94f8a0dee9.crt'),
    ca: fs.readFileSync('/etc/ssl/certs/gd_bundle-g2-g1.crt'),

    requestCert: false,
    rejectUnauthorized: false
}
const app = express();
app.use(function (req, res, next) {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
    res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
    res.setHeader('Access-Control-Allow-Credentials', true);
    next();
});
//const socket = require('socket.io');

const cors = require('cors');
//const app = express();
let port = process.env.PORT || 1055;

//app.use(express.static('public'));
app.use(cors());
var server = https.createServer(options, app);
const io = require('socket.io')(server, {
    cors: {
        origin: '*'
    }
});
let clients = 0
//const io = socket(server);
var sockets = {};
var arr = [];
io.sockets.on('connection', function (socket) {

    socket.on('for_all_send', function (data) {
        io.emit('for_all_recieve', {
            type: data.type,
            additional_data: data.additional_data,
        });
    });

    socket.on('message_send', function (data) {
        io.emit('message_receive', {
            data: data,
        });
    });


    socket.on('timer_send', function (data) {
        io.emit('timer_reciver', {
            data: data,
        });
    });

    socket.on('new_product_added_send', function (data) {
        io.emit('new_product_added_recived', {
            data: data,
        });
    });

    socket.on('online', function (data) {
        io.emit('offline', {
            data: data,
        });
    });

    socket.on('comment_send', function (data) {
        io.emit('comment_receive', {
            data: data,
        });
    });

    socket.on('chat_message_send', function (data) {
        io.emit('chat_message_receive', {
            data: data,
        });
    });

    socket.on('delete_chat_message_send', function (data) {
        io.emit('delete_chat_message_receive', {
            data: data,
        });
    });

    socket.on('bid_send', function (data) {
        io.emit('bid_recived', {
            data: data,
        });
    });

    socket.on('place_lot_for_bidding_send', function (data) {
        io.emit('place_lot_for_bidding_recived', {
            data: data,
        });
    });

    socket.on('place_a_bid_send', function (data) {
        io.emit('place_a_bid_recived', {
            data: data,
        });
    });

    socket.on('time_end_bidding_send', function (data) {
        io.emit('time_end_bidding_recived', {
            data: data,
        });
    });


    socket.on('disconnect', function () {
        if (sockets[socket.id] != undefined) {
            mydb.releaseRequest(sockets[socket.id].user_id).then(function (result) {
                console.log('disconected: ' + sockets[socket.id].request_id);
                io.emit('request-released', {
                    'request_id': sockets[socket.id].request_id
                });
                delete sockets[socket.id];
            });
        }
    });
    // code goes here...
});
server.listen(port, function () {
    console.log('Express server listening on port ' + server.address().port);
});
