# from flask import Flask, render_template, request
# from keras.preprocessing.image import load_img
# from keras.preprocessing.image import img_to_array
# from keras.applications.vgg16 import preprocess_input
# from keras.applications.vgg16 import decode_predictions
# # from keras.applications.vgg16 import VGG16
# from keras.applications.resnet50 import ResNet50

# app = Flask(__name__)
# model = ResNet50()
# # model = VGG16()

# @app.route('/', methods=['GET'])
# def hello_word():
#     return render_template('deteksi.html')

# @app.route('/', methods=['POST'])
# def predict():
#     imagefile= request.files['imagefile']
#     image_path = "./images/" + imagefile.filename
#     imagefile.save(image_path)

#     image = load_img(image_path, target_size=(224, 224))
#     image = img_to_array(image)
#     image = image.reshape((1, image.shape[0], image.shape[1], image.shape[2]))
#     image = preprocess_input(image)
#     yhat = model.predict(image)
#     label = decode_predictions(yhat)
#     label = label[0][0]

#     classification = '%s (%.2f%%)' % (label[1], label[2]*100)


#     return render_template('deteksi.html', prediction=classification)


# if __name__ == '__main__':
#     app.run(port=3000, debug=True)

from flask import Flask, render_template, request
from keras.preprocessing.image import load_img, img_to_array
from keras.applications.resnet50 import ResNet50, preprocess_input, decode_predictions
from keras.models import load_model
from PIL import Image, ImageOps
import numpy as np

app = Flask(__name__)

# Load models and class names
model_resnet = ResNet50(weights='imagenet')
custom_model = load_model("C:/xampp/htdocs/CritterShield/keras_model.h5", compile=False)
class_names = [line.strip() for line in open("C:/xampp/htdocs/CritterShield/labels.txt", "r").readlines()]

@app.route('/', methods=['GET', 'POST'])
def predict():
    if request.method == 'POST':
        # Process uploaded image
        imagefile = request.files['imagefile']
        image_path = "./images/" + imagefile.filename
        imagefile.save(image_path)

        image = Image.open(image_path).convert("RGB")
        image = image.resize((224, 224))
        image_array = np.array(image)
        normalized_image_array = (image_array.astype(np.float32) / 127.5) - 1
        data = np.expand_dims(normalized_image_array, axis=0)

        # Predict using ResNet50
        image_resnet = load_img(image_path, target_size=(224, 224))
        image_resnet = img_to_array(image_resnet)
        image_resnet = np.expand_dims(image_resnet, axis=0)
        image_resnet = preprocess_input(image_resnet)
        yhat_resnet = model_resnet.predict(image_resnet)
        label_resnet = decode_predictions(yhat_resnet)[0][0]

        # Predict using custom model
        prediction_custom = custom_model.predict(data)
        index_custom = np.argmax(prediction_custom)
        class_name_custom = class_names[index_custom]
        confidence_score_custom = prediction_custom[0][index_custom]

        return render_template('deteksi.html', 
                               prediction_resnet=label_resnet[1],
                               confidence_resnet=label_resnet[2]*100,
                               prediction_custom=class_name_custom[2:],
                               confidence_custom=confidence_score_custom*100,
                               image_path=image_path)
    else:
        return render_template('deteksi.html')

if __name__ == '__main__':
    app.run(port=3000, debug=True)
