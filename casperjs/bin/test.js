var casper = require('casper').create({verbose: true, logLevel: "debug", waitTimeout : 5000});
casper.start('http://vk.com/wall-63877037_214', function () { this.capture('vk.png'); });
casper.run();