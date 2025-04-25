import sys
import torch
from transformers import DistilBertForSequenceClassification, DistilBertTokenizerFast

def predict_sqli(input_text):
    # Path to your saved model
    model_path = './sql_injection_model'
    
    # Load the tokenizer and model
    tokenizer = DistilBertTokenizerFast.from_pretrained('distilbert-base-uncased')
    model = DistilBertForSequenceClassification.from_pretrained(model_path)
    
    # Put model in evaluation mode
    model.eval()
    
    # Tokenize the input
    inputs = tokenizer(input_text, truncation=True, padding=True, return_tensors="pt")
    
    # Make prediction
    with torch.no_grad():
        outputs = model(**inputs)
        predictions = torch.nn.functional.softmax(outputs.logits, dim=-1)
        prediction = torch.argmax(predictions, dim=-1).item()
    
    return prediction

if __name__ == "__main__":
    if len(sys.argv) > 1:
        input_text = sys.argv[1]
        result = predict_sqli(input_text)
        print(result)
    else:
        print("No input provided")