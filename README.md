# Scenario 2: ML-Powered SQL Injection Detection (Without Prepared Statements)

This login system uses a **DistilBERT-based machine learning model** to detect SQL Injection inputs before executing the query. However, it still uses a vulnerable query backend.

## Protection via ML Model

Inputs are scanned by `predict_sqli.py`, which loads `model.safetensors` trained on SQLi datasets. If the model detects a malicious pattern, access is blocked **before** the SQL query is executed.

## How it Works

1. `authenticate.php` receives user input.
2. Calls the Python script using `shell_exec()`.
3. If the model flags the input as malicious (`1`), login is blocked.
4. Otherwise, raw SQL query is executed (still vulnerable to SQLi if model fails).

## ⚠Limitations

- This is a hybrid approach with **machine learning but no traditional protection**.
- If the model fails to detect a novel SQLi payload, the system is still vulnerable.
- This code is **not recommended for production**, but useful for showcasing AI in security.

## Requirements

- `transformers`, `datasets`, `evaluate`, `scikit-learn`, `torch`
- `sql_injection_dataset.csv` for training (if retraining)
- `model.safetensors` + tokenizer in `./sql_injection_model/`
