require("dotenv").config();
const express = require("express");
const app = express();
const cors = require("cors");
const readQrImageFromUrl = require("./read.js");
const writeQrImageThenUploadToExternalService = require("./write.js");

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cors());

app.get("/", (req, res) => {
  res.status(200).send({
    routes: [
      {
        method: "POST",
        path: "/read",
        required_request_body: {
          url: "string",
        },
        description: "Read QR code from image url",
      },
      {
        method: "POST",
        path: "/write",
        required_request_body: {
          string: "string",
        },
        description: "Write QR code from string and give url of the image",
      },
    ],
  });
  return;
});

app.post("/read", async (req, res) => {
  const url = req.body.url;
  if (!url) return res.status(400).send("url field is required");
  const result = await readQrImageFromUrl(url);
  console.log("result: ", result);
  res.status(200).send(result);
  return;
});

app.post("/write", async (req, res) => {
  const string = req.body.string;
  if (!string) return res.status(400).send("string field is required");
  const result = await writeQrImageThenUploadToExternalService(string);
  res.status(200).send(result);
  return;
});

app.listen(5000, () => {
  console.log("Server is running on port 5000");
});

module.exports = app;
