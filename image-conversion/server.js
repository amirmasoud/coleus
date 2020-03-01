#!/usr/bin/env node

var amqp = require('amqplib/callback_api');

amqp.connect('amqp://rabbitmq', function (error0, connection) {
    if (error0) {
        throw error0;
    }
    connection.createChannel(function (error1, channel) {
        if (error1) {
            throw error1;
        }

        var queue = 'image-conversion';

        channel.assertQueue(queue, {
            durable: false
        });

        console.log(" [*] Waiting for messages in %s. To exit press CTRL+C", queue);

        channel.consume(queue, function (msg) {
            const imageConversion = require("image-conversion");

            console.log(" [x] Received %s", msg.content.toString());
            imageConversion.urltoBlob("https://media.negarin.test/public/10/download.jpeg").then(file => {
                console.log(file.size);
                // imageConversion.compressAccurately(image, 200).then(res => {
                //     console.log(res);
                // })
            });
        }, {
            noAck: true
        });
    });
});