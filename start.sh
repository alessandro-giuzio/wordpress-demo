#!/bin/bash

# WordPress Development Environment Startup Script

echo "🚀 Starting WordPress Development Environment..."
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker and try again."
    exit 1
fi

# Check if .env file exists
if [ ! -f .env ]; then
    echo "📋 Creating .env file from .env.example..."
    cp .env.example .env
fi

# Start the containers
echo "🐳 Starting Docker containers..."
docker compose up -d

# Wait for services to be ready
echo "⏱️  Waiting for services to start..."
sleep 10

# Check if WordPress is accessible
if curl -s http://localhost:8080 > /dev/null; then
    echo ""
    echo "✅ WordPress Development Environment is ready!"
    echo ""
    echo "🌐 Access your sites:"
    echo "   WordPress:  http://localhost:8080"
    echo "   phpMyAdmin: http://localhost:8081"
    echo ""
    echo "🔐 Database credentials:"
    echo "   Username: wordpress"
    echo "   Password: wordpress"
    echo "   Database: wordpress"
    echo ""
    echo "📚 Getting Started:"
    echo "   1. Complete WordPress setup at http://localhost:8080"
    echo "   2. Go to Plugins and activate 'My First Plugin'"
    echo "   3. Visit Settings > My First Plugin to explore"
    echo "   4. Create a post/page and use [hello_world] shortcode"
    echo ""
    echo "🛠️  Start developing:"
    echo "   - Edit files in the plugins/ directory"
    echo "   - Changes are reflected immediately"
    echo "   - Check the README.md for detailed instructions"
    echo ""
else
    echo "⚠️  WordPress might still be starting up..."
    echo "   Try accessing http://localhost:8080 in a few moments"
fi