import pandas as pd
import torch
from sklearn.model_selection import train_test_split
from transformers import (
    DistilBertTokenizerFast,
    DistilBertForSequenceClassification,
    Trainer,
    TrainingArguments
)

# 1. Load your dataset with original column names
df = pd.read_csv("sql_injection_dataset.csv")[['Query', 'Label']].dropna()
df['Label'] = df['Label'].astype(int)

# 2. Prepare data in lists (compatible with older versions)
texts = df['Query'].tolist()
labels = df['Label'].tolist()

# 3. Train-test split
train_texts, test_texts, train_labels, test_labels = train_test_split(
    texts, labels, test_size=0.2, random_state=42
)

# 4. Tokenization
tokenizer = DistilBertTokenizerFast.from_pretrained('distilbert-base-uncased')
train_encodings = tokenizer(train_texts, truncation=True, padding=True)
test_encodings = tokenizer(test_texts, truncation=True, padding=True)

# 5. Create PyTorch Dataset
class SQLiDataset(torch.utils.data.Dataset):
    def __init__(self, encodings, labels):
        self.encodings = encodings
        self.labels = labels

    def __getitem__(self, idx):
        item = {key: torch.tensor(val[idx]) for key, val in self.encodings.items()}
        item['labels'] = torch.tensor(self.labels[idx])
        return item

    def __len__(self):
        return len(self.labels)

train_dataset = SQLiDataset(train_encodings, train_labels)
test_dataset = SQLiDataset(test_encodings, test_labels)

# 6. Model setup
model = DistilBertForSequenceClassification.from_pretrained(
    'distilbert-base-uncased',
    num_labels=2
)

# 7. Training arguments (compatible with v3.x)
training_args = TrainingArguments(
    output_dir='./sql_injection_model',
    do_train=True,
    do_eval=True,
    per_device_train_batch_size=16,
    per_device_eval_batch_size=16,
    num_train_epochs=3,
    save_steps=500,
    save_total_limit=2,
)

# 8. Initialize Trainer
trainer = Trainer(
    model=model,
    args=training_args,
    train_dataset=train_dataset,
    eval_dataset=test_dataset,
)

# 9. Train and save
trainer.train()
trainer.save_model('./sql_injection_model')
print("✅ Training complete! Model saved to ./sql_injection_model")