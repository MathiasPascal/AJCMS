import sys
from transformers import GPT2Tokenizer, GPT2LMHeadModel

def load_model_and_tokenizer(model_dir):
    tokenizer = GPT2Tokenizer.from_pretrained(model_dir)
    model = GPT2LMHeadModel.from_pretrained(model_dir)
    return model, tokenizer

def predict_verdict(text, model, tokenizer):
    inputs = tokenizer.encode(text, return_tensors='pt')
    outputs = model.generate(inputs, max_length=50)
    prediction = tokenizer.decode(outputs[0], skip_special_tokens=True)
    return prediction

if __name__ == "__main__":
    model_dir = './fine-tuned-gpt2'  # Adjust the path if necessary
    model, tokenizer = load_model_and_tokenizer(model_dir)
    input_text = sys.argv[1]
    predicted_verdict = predict_verdict(input_text, model, tokenizer)
    print(predicted_verdict)
