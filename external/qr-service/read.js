const Jimp = require("jimp");
const request = require("request");
const QrCodeReader = require("qrcode-reader");

const downloadImage = (url, callback) => {
  request({ url, encoding: null }, (error, response, body) => {
    if (!error && response.statusCode === 200) {
      callback(null, body);
    } else {
      callback(
        error ||
          new Error(
            `Failed to download image. Status code: ${response.statusCode}`
          )
      );
    }
  });
};

module.exports = readQrImageFromUrl = (url) => {
  return new Promise((resolve, reject) => {
    downloadImage(url, (error, imageBuffer) => {
      if (error) {
        reject(error);
        return;
      }
      Jimp.read(imageBuffer, (err, image) => {
        if (err) {
          reject(err);
          return;
        }
        const qrCodeInstance = new QrCodeReader();
        qrCodeInstance.callback = function (err, value) {
          if (err) {
            reject(err);
            return;
          }
          console.log('Decoded QR code:', value.result);
          resolve(value.result);
        };
        qrCodeInstance.decode(image.bitmap);
      });
    });
  });
};
