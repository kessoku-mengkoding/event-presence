const QRCode = require("qrcode");
const FormData = require("form-data");
const { v4: uuidv4 } = require("uuid");

module.exports = async (string) => {
  const dataURL = await QRCode.toDataURL(string, {
    errorCorrectionLevel: "H",
  });
  const buffer = Buffer.from(dataURL.split(",")[1], "base64");

  try {
    const formData = new FormData();
    formData.append("image", buffer, `${uuidv4()}.png`);

    let response = await fetch(
      "https://api.imgbb.com/1/upload?key=86cfe2f49c006b977061db418ed1f8ba",
      {
        method: "POST",
        body: formData,
      }
    );
    response = await response.json();

    if (response.data && response.data.url) {
      console.log("QR code uploaded to ImgBB:", response.data.url);
      return response.data.url;
    } else {
      console.error("Failed to upload QR code to ImgBB:", response);
    }
  } catch (error) {
    console.error("Error uploading QR code to ImgBB:", error.message ?? error);
  }
};
