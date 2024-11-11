const escpos = require('escpos');
escpos.USB = require('escpos-usb');

const device = new escpos.USB();
const printer = new escpos.Printer(device);

const printReceipt = (data) => {
    device.open(() => {
        printer
            .align('CT')
            .text('Receipt')
            .text('--------------------')
            .text('Item 1      $5.00')
            .text('Item 2      $10.00')
            .text('--------------------')
            .text('Total       $15.00')
            .cut()
            .close();
    });
};

printReceipt();
