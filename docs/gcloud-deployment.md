# Google Cloud App Engine Deployment

## Install Google Cloud CLI (Ubuntu)

```bash
curl https://packages.cloud.google.com/apt/doc/apt-key.gpg | sudo gpg --dearmor -o /usr/share/keyrings/cloud.google.gpg

echo "deb [signed-by=/usr/share/keyrings/cloud.google.gpg] https://packages.cloud.google.com/apt cloud-sdk main" | sudo tee /etc/apt/sources.list.d/google-cloud-sdk.list

sudo apt-get update && sudo apt-get install -y google-cloud-cli
```

## Authenticate and Set Project

```bash
gcloud auth login
gcloud config set project YOUR_PROJECT_ID
```

## Deploy

```bash
gcloud app deploy
```

To skip the confirmation prompt:

```bash
gcloud app deploy --quiet
```

## Notes

- Configuration is in `app.yaml` (runtime, env variables, static handlers).
- `app.yaml` sets `DB_CONNECTION=pgsql` so GAE always uses Supabase PostgreSQL.
- Local `.env` sets `DB_CONNECTION=mysql` for local development with MySQL.
- Do **not** commit `.env` — it contains local credentials.
- `app.yaml` contains Supabase credentials; keep the repo private or move secrets to Google Secret Manager.
