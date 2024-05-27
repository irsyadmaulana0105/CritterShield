const express = require("express");
// const cors = require("cors");
const TeachableMachine  = require("@sashido/teachablemachine-node");
const bodyParser = require("body-parser");

const model = new TeachableMachine({
  // modelUrl: "https://teachablemachine.withgoogle.com/models/r6BBk-hiN/"
    modelUrl: "https://teachablemachine.withgoogle.com/models/3mJul2-ga/",
});

const app = express();
app.use(express.json());
app.use(bodyParser.json());
const port = process.env.port || 4000;

app.use(express.urlencoded({ extended: false }));
// app.use(cors());

app.get("/", (req, res) => {
  res.send(`
    <form action="/image/classify" method="POST" enctype="multipart/form-data">
      <p>Enter image url</p>
      <input type=file name='ImageUrl' autocomplete=off>
      <button type="submit">Predict Image</button> <!-- Ditambah "type" -->
    </form>
  `);
});

app.post("/image/classify", async (req, res) => {
    const url = req.body.ImageUrl;
    return model
    .classify({
      imageUrl:url,
    })
    .then((predictions) => {
      res.json(predictions);
    })
    .catch((e) => {
      res.status(500).send("ada yg salah");
    })

    // try {
    //     const predictions = await model.classify({ imageUrl: url });
    //     res.json(predictions);
    // } catch (e) {
    //     res.status(500).send("Something went wrong");
    // }
});

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`);
});
