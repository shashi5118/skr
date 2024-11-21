# predict.py
import sys
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.image import load_img, img_to_array
import numpy as np

# Load the pre-trained model
model = load_model('cancer_model.h5')

# Get the image file path from command-line arguments
image_path = sys.argv[1]

# Load and preprocess the image
image = load_img(image_path, target_size=(224, 224))  # Adjust size as per your model
image = img_to_array(image) / 255.0
image = np.expand_dims(image, axis=0)

# Predict using the model
prediction = model.predict(image)
result = "Cancerous" if prediction[0][0] > 0.5 else "Non-Cancerous"

print(result)
