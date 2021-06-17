var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var db = require('./db.js');
var mydb = new db();

app.get('/', function(req, res) {
    res.send('Working Fine');
});
var sockets = {};
var arr = [];
io.on('connection', function(socket) {


    socket.on('message_send', function(data) {
        io.emit('message_receive', {
            data: data,
        });
    });

    socket.on('timer_send', function(data) {
        io.emit('timer_reciver', {
            data: data,
        });
    });

    socket.on('online', function(data) {
        io.emit('offline', {
            data: data,
        });
    });

    socket.on('comment_send', function(data) {
        io.emit('comment_receive', {
            data: data,
        });
    });

    socket.on('chat_message_send', function(data) {
        io.emit('chat_message_receive', {
            data: data,
        });
    });

    socket.on('delete_chat_message_send', function(data) {
        io.emit('delete_chat_message_receive', {
            data: data,
        });
    });

    socket.on('bid_send', function(data) {
        io.emit('bid_recived', {
            data: data,
        });
    });

    socket.on('place_lot_for_bidding_send', function(data) {
        io.emit('place_lot_for_bidding_recived', {
            data: data,
        });
    });

    socket.on('place_a_bid_send', function(data) {
        io.emit('place_a_bid_recived', {
            data: data,
        });
    });

    socket.on('time_end_bidding_send', function(data) {
        io.emit('time_end_bidding_recived', {
            data: data,
        });
    });


    socket.on('disconnect', function() {
        if (sockets[socket.id] != undefined) {
            mydb.releaseRequest(sockets[socket.id].user_id).then(function(result) {
                console.log('disconected: ' + sockets[socket.id].request_id);
                io.emit('request-released', {
                    'request_id': sockets[socket.id].request_id
                });
                delete sockets[socket.id];
            });
        }
    });
});

http.listen(1029, function() {
    console.log('working fine');
});

    // socket.on('comment_send', function(data) {
    //     io.emit('comment_receive', {
    //         'comment_id': data.comment_id,
    //         'post_id': data.post_id,
    //         'user_id': data.user_id,
    //         'user_name': data.user_name,
    //         'user_image': data.user_image,
    //         'comment': data.comment,
    //         'created_at': data.created_at,
    //         // 'comments_count': data.comments_count
    //     });
    // });
