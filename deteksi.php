<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CritterShield</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7DFD4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            /* flex-direction: column; */
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-family: "courier";
            color: #364f6b;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            width: 35%;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            width: 100%;
            max-width: 750px; /* Batas maksimal lebar kartu */
            height: 200px;
            box-sizing: border-box;
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
        }

        .button-container button:hover {
            background-color: #0056b3;
        }

        #webcam-container {
            margin-top: 20px;
            border: 2px solid #007bff;
            background: white;
            width: 300px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;

        }

        #label-container {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #label-container div {
            font-size: 16px;
            padding: 5px;
            background: #e0e0e0;
            margin: 2px 0;
            border-radius: 3px;
            text-align: center;
        }

        .right-container {
            background-color: #F7DFD4;
            width: 65%;
            display: flex;
            justify-content: center;
            align-items: center; /* Mulai elemen dari atas */
            flex-direction: column;
            gap: 12px;
            padding: 10px; /* Tambahkan padding untuk jarak */
            box-sizing: border-box;
            overflow-y: auto; /* Mengaktifkan scroll vertikal jika konten terlalu tinggi */
        }

        .card-item {
            display: flex;
            flex-direction: column;
            /* align-items: center;
            justify-content: center; */
            margin-bottom: 8px; /* Menambahkan jarak antar item dalam kartu */
            gap: 5px;
        }

        .hidden {
            display: none;
        }

        .back-button {
            position: fixed;
            top: 0;
            left: 0;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007C5A;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin: 20px; /* Menambahkan jarak dari tepi */
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
    <!-- <h1>Deteksi</h1> -->
        <div class="button-container">
            <button type="button" id="camera-button" onclick="init()">Camera</button>
            <button type="button" id="file-button" onclick="file()">File</button>
            <button type="button" id="pause-button" class="hidden" onclick="pauseWebcam()">Pause</button>
            <button type="button" id="close-button" class="hidden" onclick="closeWebcam()">Close Webcam</button>
        </div>
        <div id="webcam-container" class="hidden"></div>
        <div id="label-container" class="hidden"></div>
    </div>
    <a class="back-button" href="index.php">Back</a>

    <!-- <div class="kanan" style="background-color:red;width:70%"> -->

        </div>
        <div class="right-container">
            <div class="card">
                <div class="card-item">
                    <strong>Isi:</strong>
                    <span id="isi"></span>
                    <!-- <span><?php //echo htmlspecialchars($row['isi']); ?></span> -->
                </div>
            </div>
            <div class="card">
            <div class="card-item">
                    <strong>Penanganan:</strong>
                    <!-- <span><?php //echo htmlspecialchars($row['penanganan']); ?></span> -->
                    <span id="penanganan"></span>

                </div>
            </div>
            <div class="card">
                <div class="card-item">
                    <strong>Pencegahan:</strong>
                    <!-- <span><?php //echo htmlspecialchars($row['pencegahan']); ?></span> -->
                    <span id="pencegahan"></span>
                </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <script type="text/javascript">
        const URL = "https://teachablemachine.withgoogle.com/models/3mJul2-ga/";

let model, webcam, labelContainer, maxPredictions;
let isPaused = false;

// Load the image model and setup the webcam
async function init() {
    const modelURL = URL + "model.json";
    const metadataURL = URL + "metadata.json";

    // load the model and metadata
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();

    // Convenience function to setup a webcam
    const flip = true; // whether to flip the webcam
    webcam = new tmImage.Webcam(300, 300, flip); // width, height, flip
    await webcam.setup(); // request access to the webcam
    await webcam.play();
    window.requestAnimationFrame(loop);

    // append elements to the DOM
    document.getElementById("webcam-container").appendChild(webcam.canvas);
    labelContainer = document.getElementById("label-container");
    for (let i = 0; i < maxPredictions; i++) { // and class labels
        labelContainer.appendChild(document.createElement("div"));
    }

    // Show the pause and close buttons, hide the camera and file buttons
    document.getElementById("pause-button").classList.remove("hidden");
    document.getElementById("close-button").classList.remove("hidden");
    document.getElementById("camera-button").classList.add("hidden");
    document.getElementById("file-button").classList.add("hidden");
}

async function loop() {
    if (!isPaused) {
        webcam.update(); // update the webcam frame
        await predict();
        // Clear predictions
        for (let i = 0; i < maxPredictions; i++) {
            labelContainer.childNodes[i].innerHTML = '';
        }
    }
    window.requestAnimationFrame(loop);
}

// run the webcam image through the image model
async function predict() {
    const prediction = await model.predict(webcam.canvas);
    // alert(prediction);
    if (isPaused) {
        for (let i = 0; i < maxPredictions; i++) {
            const classPrediction =
            prediction[i].className + ": " + prediction[i].probability.toFixed(2);
            labelContainer.childNodes[i].innerHTML = classPrediction;
        }
    }
    else if (!isPaused)
    {
        document.getElementById("isi").innerText = "";
        document.getElementById("penanganan").innerText = "";
        document.getElementById("pencegahan").innerText = "";
    }
    return prediction;
}

function file() {
    window.location.href = 'jspicek/index.php';
}

async function pauseWebcam() {
    if (!isPaused) {
        isPaused = true;
        const prediction = await model.predict(webcam.canvas);
        if (webcam && webcam.webcamStarted) {
            webcam.stop();
        }
        document.getElementById("pause-button").textContent = "Resume";
        await predict(); // Show predictions once paused
        let maxPrediction = prediction[0].probability.toFixed(2);
        let className = prediction[0].className;
        for (let i = 1; i < maxPredictions; i++) {
            if (prediction[i].probability.toFixed(2) > maxPrediction) {
                maxPrediction = prediction[i].probability.toFixed(2);
                className = prediction[i].className;
            }
        }
        let id;
        switch (className) {
            case 'blast':
                id = 1;
                break;
            case 'blight':
                id = 2;
                break;
            case 'tungro':
                id = 3;
                break;
        }
        
        // Send id to PHP script using AJAX
        if (id) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "pause.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // xhr.onreadystatechange = function() {
            //     if (xhr.readyState === XMLHttpRequest.DONE) {
            //         if (xhr.status === 200) {
            //             // Handle successful response
            //             alert(xhr.responseText);

            //         } else {
            //             // Handle error
            //             alert("Error occurred: " + xhr.statusText);
            //         }
            //     }
            // };
            // xhr.onreadystatechange = function() {
            //     if (xhr.readyState === XMLHttpRequest.DONE) {
            //         if (xhr.status === 200) {
            //             // Handle successful response
            //             var responseData = JSON.parse(xhr.responseText);
            //             alert("sadsa")
            //             // Mengambil elemen-elemen <span> berdasarkan ID-nya
            //             var idSpan = document.getElementById("id");
            //             var penangananSpan = document.getElementById("penanganan");
            //             var pencegahanSpan = document.getElementById("pencegahan");
                        
            //             // Memastikan bahwa elemen-elemen <span> ditemukan sebelum menetapkan nilainya
            //             if (idSpan && penangananSpan && pencegahanSpan) {
            //                 // Menetapkan nilai ID, penanganan, dan pencegahan dari setiap objek data ke elemen-elemen <span>
            //                 for (var i = 0; i < responseData.length; i++) {
            //                     idSpan.innerText = "ID: " + responseData[i].id;
            //                     penangananSpan.innerText = "Penanganan: " + responseData[i].penanganan;
            //                     pencegahanSpan.innerText = "Pencegahan: " + responseData[i].pencegahan;
            //                 }
            //             } else {
            //                 // Jika salah satu atau lebih elemen <span> tidak ditemukan, tangani kesalahan di sini
            //                 console.error("One or more <span> elements not found.");
            //             }
            //         } else {
            //             // Handle error
            //             alert("Error occurred: " + xhr.statusText);
            //         }
            //     }
            // }
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle successful response
                        var responseData = JSON.parse(xhr.responseText);
                        
                        // Jika Anda yakin bahwa respons hanya akan berisi satu objek data, Anda bisa mengaksesnya langsung
                        if (responseData.length > 0) {
                            var obj = responseData[0];
                            document.getElementById("isi").innerText = obj.isi;
                            document.getElementById("penanganan").innerText = obj.penanganan;
                            document.getElementById("pencegahan").innerText = obj.pencegahan;
                        } else {
                            console.error("No data found in the response.");
                        }
                    } else {
                        // Handle error
                        alert("Error occurred: " + xhr.statusText);
                    }
                }
            };


            xhr.send("id=" + encodeURIComponent(id));
        } else {
            alert("ID not determined.");
        }
    } else {
        isPaused = false;
        if (webcam) {
            await webcam.play();
        }
        document.getElementById("pause-button").textContent = "Pause";
    }
}





function closeWebcam() {
    const confirmation = confirm("Are you sure you want to close the webcam?");
    if (confirmation) {
        webcam.stop();
        const webcamContainer = document.getElementById("webcam-container");
        while (webcamContainer.firstChild) {
            webcamContainer.removeChild(webcamContainer.firstChild);
        }
        labelContainer.innerHTML = "";
        // Hide the pause and close buttons, show the camera and file buttons
        document.getElementById("pause-button").classList.add("hidden");
        document.getElementById("close-button").classList.add("hidden");
        document.getElementById("camera-button").classList.remove("hidden");
        document.getElementById("file-button").classList.remove("hidden");
        document.getElementById("isi").innerText = "";
        document.getElementById("penanganan").innerText = "";
        document.getElementById("pencegahan").innerText = "";
        isPaused = false; // Reset isPaused status
    }
}

    </script>
    <a class="back-button" href="index.php" class="back-button">Back</a>
</body>
</html>
