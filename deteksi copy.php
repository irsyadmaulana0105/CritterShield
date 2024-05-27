<!-- <div>Teachable Machine Image Model</div>
<button type="button" onclick="init()">camera</button>
<button type="button" onclick="file()">file</button>

<div id="webcam-container"></div>
<div id="label-container"></div>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
<script type="text/javascript">

    const URL = "https://teachablemachine.withgoogle.com/models/3mJul2-ga/";

    let model, webcam, labelContainer, maxPredictions;

    // Load the image model and setup the webcam
    async function init() {
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";

        // load the model and metadata
        // Refer to tmImage.loadFromFiles() in the API to support files from a file picker
        // or files from your local hard drive
        // Note: the pose library adds "tmImage" object to your window (window.tmImage)
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();

        // Convenience function to setup a webcam
        const flip = true; // whether to flip the webcam
        webcam = new tmImage.Webcam(200, 200, flip); // width, height, flip
        await webcam.setup(); // request access to the webcam
        await webcam.play();
        window.requestAnimationFrame(loop);

        // append elements to the DOM
        document.getElementById("webcam-container").appendChild(webcam.canvas);
        labelContainer = document.getElementById("label-container");
        for (let i = 0; i < maxPredictions; i++) { // and class labels
            labelContainer.appendChild(document.createElement("div"));
        }
    }

    async function loop() {
        webcam.update(); // update the webcam frame
        await predict();
        window.requestAnimationFrame(loop);
    }

    // run the webcam image through the image model
    async function predict() {
        // predict can take in an image, video or canvas html element
        const prediction = await model.predict(webcam.canvas);
        for (let i = 0; i < maxPredictions; i++) {
            const classPrediction =
                prediction[i].className + ": " + prediction[i].probability.toFixed(2);
            labelContainer.childNodes[i].innerHTML = classPrediction;
        }
    }

    function file() {
        window.location.href = 'jspicek/index.php';
    }
</script> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CritterShield</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-family: "courier";
            color: #364f6b;
        }
        .button-container {
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
        }
        button:hover {
            background-color: #0056b3;
        }
        #webcam-container {
            margin-top: 20px;
            border: 2px solid #007bff;
            width: fit-content;
            background: white;
            margin-bottom: 20px;
        }
        #label-container {
            margin-top: 10px;
        }
        #label-container div {
            font-size: 16px;
            padding: 5px;
            background: #e0e0e0;
            margin: 2px 0;
            border-radius: 3px;
            text-align: center;
        }
        .hidden {
            display: none;
        }
        .back-button {
            position: absolute;
            top: 20px; /* Adjust as needed */
            left: 20px; /* Adjust as needed */
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            z-index: 999; /* Ensure the button appears on top of other content */
        }
        .back-button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <h1>Train</h1>
    <div class="button-container">
        <button type="button" onclick="init()">Camera</button>
        <button type="button" onclick="file()">File</button>
        <button type="button" id="close-button" class="hidden" onclick="closeWebcam()">Close</button>
    </div>
    <div id="webcam-container"></div>
    <div id="label-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <script type="text/javascript">
        const URL = "https://teachablemachine.withgoogle.com/models/3mJul2-ga/";

        let model, webcam, labelContainer, maxPredictions;

        // Load the image model and setup the webcam
        async function init() {
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";

            // load the model and metadata
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();

            // Convenience function to setup a webcam
            const flip = true; // whether to flip the webcam
            webcam = new tmImage.Webcam(200, 200, flip); // width, height, flip
            await webcam.setup(); // request access to the webcam
            await webcam.play();
            window.requestAnimationFrame(loop);

            // append elements to the DOM
            document.getElementById("webcam-container").appendChild(webcam.canvas);
            labelContainer = document.getElementById("label-container");
            for (let i = 0; i < maxPredictions; i++) { // and class labels
                labelContainer.appendChild(document.createElement("div"));
            }

            // Show the close button
            document.getElementById("close-button").classList.remove("hidden");
        }

        async function loop() {
            webcam.update(); // update the webcam frame
            await predict();
            window.requestAnimationFrame(loop);
        }

        // run the webcam image through the image model
        async function predict() {
            // predict can take in an image, video or canvas html element
            const prediction = await model.predict(webcam.canvas);
            for (let i = 0; i < maxPredictions; i++) {
                const classPrediction =
                    prediction[i].className + ": " + prediction[i].probability.toFixed(2);
                labelContainer.childNodes[i].innerHTML = classPrediction;
            }
        }

        function file() {
            window.location.href = 'jspicek/index.php';
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
                // Hide the close button
                document.getElementById("close-button").classList.add("hidden");
            }
        }
    </script>
    <a class="back-button" href="index.php" class="back-button">Back</a>
</body>

</html>
