// const express = require("express");
// const cors = require("cors");
// const TeachableMachine  = require("@sashido/teachablemachine-node");
// const bodyParser = require("body-parser");
// // const multer  = require('multer');
// // const upload = multer({ dest: 'uploads/' });

// const model = new TeachableMachine({
//   // modelUrl: "https://teachablemachine.withgoogle.com/models/r6BBk-hiN/"
//     modelUrl: "https://teachablemachine.withgoogle.com/models/3mJul2-ga/",
// });

// const app = express();
// app.use(express.json());
// app.use(bodyParser.json());
// const port = process.env.port || 4000;

// app.use(express.urlencoded({ extended: false }));
// app.use(cors());

// app.get("/", (req, res) => {
//   res.send(`
//     <form action="/image/classify" method="POST">
//       <p>Enter image url</p>
//       <input name='ImageUrl' autocomplete=off>
//       <button type="submit">Predict Image</button> <!-- Ditambah "type" -->
//     </form>
//   `);
// });

// app.post("/image/classify", async (req, res) => {
//     const url = req.body.ImageUrl;
//     try {
//         const predictions = await model.classify({ imageUrl: url });
//         res.json(predictions);
//     } catch (e) {
//         console.error("Error occurred during image classification:", e);
//         res.status(500).send("Terjadi kesalahan dalam proses klasifikasi gambar. Silakan coba lagi.");
//     }
// });

// app.listen(port, () => {
//   console.log(`Example app listening at http://localhost:${port}`);
// });

const express = require("express");
const cors = require("cors");
const TeachableMachine  = require("@sashido/teachablemachine-node");
const bodyParser = require("body-parser");
const multer  = require('multer');

const model = new TeachableMachine({
    modelUrl: "https://teachablemachine.withgoogle.com/models/3mJul2-ga/",
});

const app = express();
app.use(express.json());
app.use(bodyParser.json());
const port = process.env.port || 4000;

app.use(express.urlencoded({ extended: false }));
app.use(cors());

// Konfigurasi multer untuk menyimpan gambar di folder "uploads"
const upload = multer({ dest: 'uploads/' });

app.get("/", (req, res) => {
  res.send(`
    <form action="/image/classify" method="POST" enctype="multipart/form-data">
      <p>Select image</p>
      <input type="file" name="image">
      <button type="submit">Predict Image</button>
    </form>
  `);
});

// Menangani unggahan gambar dengan multer
app.post("/image/classify", upload.single('image'), async (req, res) => {
    const file = req.file; // File yang diunggah akan tersedia di sini
    if (!file) {
        return res.status(400).send('No file uploaded.');
    }

    const imageUrl = file.path; // Path tempat file disimpan

    try {
        const predictions = await model.classify({ imageUrl });
        res.json(predictions);
    } catch (e) {
        console.error("Error occurred during image classification:", e);
        res.status(500).send("Terjadi kesalahan dalam proses klasifikasi gambar. Silakan coba lagi.");
    }
});

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`);
});

// const express = require("express");
// const cors = require("cors");
// const TeachableMachine  = require("@sashido/teachablemachine-node");
// const bodyParser = require("body-parser");
// const multer  = require('multer');
// const fs = require('fs');

// const model = new TeachableMachine({
//     modelUrl: "https://teachablemachine.withgoogle.com/models/3mJul2-ga/",
// });

// const app = express();
// app.use(express.json());
// app.use(bodyParser.json());
// const port = process.env.port || 4000;

// app.use(express.urlencoded({ extended: false }));
// app.use(cors());

// // Konfigurasi multer untuk menyimpan gambar di folder "uploads"
// const upload = multer({ dest: 'uploads/' });

// app.get("/", (req, res) => {
//   res.send(`
//     <form action="/image/classify" method="POST" enctype="multipart/form-data">
//       <p>Select image</p>
//       <input type="file" name="image">
//       <button type="submit">Predict Image</button>
//     </form>
//   `);
// });

// // Menangani unggahan gambar dengan multer
// app.post("/image/classify", upload.single('image'), async (req, res) => {
//     const file = req.file; // File yang diunggah akan tersedia di sini
//     if (!file) {
//         return res.status(400).send('No file uploaded.');
//     }

//     const imageBuffer = fs.readFileSync(file.path); // Membaca file sebagai buffer
//     try {
//         const predictions = await model.classify({ imageBuffer }); // Menggunakan buffer gambar
//         res.json(predictions);
//     } catch (e) {
//         console.error("Error occurred during image classification:", e);
//         res.status(500).send("Terjadi kesalahan dalam proses klasifikasi gambar. Silakan coba lagi.");
//     } finally {
//         // Hapus file setelah digunakan
//         fs.unlinkSync(file.path);
//     }
// });

// app.listen(port, () => {
//   console.log(`Example app listening at http://localhost:${port}`);
// });
