#!/usr/bin/env bash

set -e  # exit immediately if any command fails

IMAGE_NAME="my-app:latest"
COMPOSE_FILE="compose.prod.yml"

echo "▶ Building Docker image: ${IMAGE_NAME}"
docker build -t "${IMAGE_NAME}" .

echo "▶ Starting containers using ${COMPOSE_FILE}"
docker-compose -f "${COMPOSE_FILE}" up -d

echo "▶ Waiting for app container to be ready..."
sleep 5

echo "▶ Running database migrations"
docker-compose -f "${COMPOSE_FILE}" exec app php artisan migrate

echo "✅ Deployment finished successfully"
