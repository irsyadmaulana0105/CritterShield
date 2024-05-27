// const TeachableMachine = require("@sashido/teachablemachine-node");
// const fs = require('fs');
// const jsonData = require('./jspicek/data.json');
// const { log } = require("console");

// console.log(jsonData.link);

// const model = new TeachableMachine({
//   modelUrl: "https://teachablemachine.withgoogle.com/models/3mJul2-ga/"
// });
// model.classify({

//   imageUrl: jsonData.link,
// }).then((predictions) => {
//   console.log("Predictions:", predictions);
//   fs.readFile('data.json', 'utf8', (err, data) => {
//       if (err) {
//           console.error("Gagal membaca file:", err);
//           return;
//       }

//       // Parse data JSON
//       const jsonData = JSON.parse(data);

//       // Ubah tanggal menjadi tanggal saat ini
//       var currentDate = new Date();

//       // Ambil tanggal, bulan, dan tahun dari objek Date
//       var day = currentDate.getDate();
//       var month = currentDate.getMonth() + 1; // Ingat bahwa bulan dimulai dari 0, jadi tambahkan 1
//       var year = currentDate.getFullYear();

//       // Ambil jam, menit, dan detik dari objek Date
//       var hours = currentDate.getHours();
//       var minutes = currentDate.getMinutes();
//       var seconds = currentDate.getSeconds();

//       // Format tanggal dan waktu dalam bentuk string
//       var dateTimeString = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds
//       jsonData.nama = predictions[0].class;
//       jsonData.skor = predictions[0].score;
//       jsonData.tanggal = dateTimeString;
      
//       // Konversi kembali ke JSON
//       console.log(jsonData)
//       const newData = JSON.stringify(jsonData, null, 2);
//       console.log(newData)


//       // Tulis kembali ke file
//       fs.writeFile('jspicek/data.json', newData, 'utf8', (err) => {
//           if (err) {
//               console.error("Gagal menulis ke file:", err);
//               return;
//           }
//           console.log("Data telah berhasil diubah.");
//       });
//   });

// }).catch((e) => {
//   console.log("ERROR", e);
// });

const TeachableMachine = require("@sashido/teachablemachine-node");
const fs = require('fs');
const path = require('path'); // To handle file paths correctly
const jsonData = require('./data.json');
const { log } = require("console");

console.log(jsonData.link);

const model = new TeachableMachine({
  modelUrl: "https://teachablemachine.withgoogle.com/models/3mJul2-ga/"
});

model.classify({
  imageUrl: jsonData.link,
})
.then((predictions) => {
  console.log("Predictions:", predictions);
  
  const dataFilePath = path.join(__dirname, 'data.json');

  fs.readFile(dataFilePath, 'utf8', (err, data) => {
      if (err) {
          console.error("Failed to read file:", err);
          return;
      }

      // Parse JSON data
      const jsonData = JSON.parse(data);

      // Get the current date and time
      const currentDate = new Date();

      // Format date and time as a string
      const dateTimeString = currentDate.toISOString().replace('T', ' ').substring(0, 19);

      // Update JSON data with predictions and current date
      jsonData.nama = predictions[0].class;
      jsonData.skor = predictions[0].score;
      jsonData.tanggal = dateTimeString;
      
      // Convert back to JSON string
      const newData = JSON.stringify(jsonData, null, 2);

      // Write updated JSON data back to file
      fs.writeFile(dataFilePath, newData, 'utf8', (err) => {
          if (err) {
              console.error("Failed to write to file:", err);
              return;
          }
          console.log("Data has been successfully updated.");
      });
  });

})
.catch((e) => {
  console.log("ERROR", e);
});
