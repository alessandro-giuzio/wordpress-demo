#!/bin/bash

# WordPress Development Environment Test Script

echo "🧪 Testing WordPress Development Environment Setup..."
echo ""

# Test 1: Check if Docker is available
echo "1️⃣  Checking Docker availability..."
if command -v docker &> /dev/null; then
    echo "   ✅ Docker is installed: $(docker --version)"
    
    if docker info &> /dev/null; then
        echo "   ✅ Docker daemon is running"
    else
        echo "   ❌ Docker daemon is not running"
        exit 1
    fi
else
    echo "   ❌ Docker is not installed"
    exit 1
fi

# Test 2: Check Docker Compose
echo ""
echo "2️⃣  Checking Docker Compose..."
if docker compose version &> /dev/null; then
    echo "   ✅ Docker Compose is available: $(docker compose version --short)"
else
    echo "   ❌ Docker Compose is not available"
    exit 1
fi

# Test 3: Validate docker-compose.yml
echo ""
echo "3️⃣  Validating Docker Compose configuration..."
if docker compose config --quiet; then
    echo "   ✅ docker-compose.yml is valid"
else
    echo "   ❌ docker-compose.yml has errors"
    exit 1
fi

# Test 4: Check environment file
echo ""
echo "4️⃣  Checking environment configuration..."
if [ -f .env ]; then
    echo "   ✅ .env file exists"
else
    if [ -f .env.example ]; then
        echo "   ⚠️  .env file missing, but .env.example exists"
        echo "      Run: cp .env.example .env"
    else
        echo "   ❌ No .env or .env.example file found"
        exit 1
    fi
fi

# Test 5: Check plugin structure
echo ""
echo "5️⃣  Checking plugin structure..."
if [ -f "plugins/my-first-plugin/my-first-plugin.php" ]; then
    echo "   ✅ Example plugin exists"
    
    # Check PHP syntax
    if php -l plugins/my-first-plugin/my-first-plugin.php &> /dev/null; then
        echo "   ✅ Plugin PHP syntax is valid"
    else
        echo "   ❌ Plugin PHP syntax errors found"
        exit 1
    fi
else
    echo "   ❌ Example plugin not found"
    exit 1
fi

# Test 6: Check if ports are available
echo ""
echo "6️⃣  Checking port availability..."
if lsof -i :8080 &> /dev/null; then
    echo "   ⚠️  Port 8080 is already in use"
    echo "      WordPress might already be running or port is occupied"
else
    echo "   ✅ Port 8080 (WordPress) is available"
fi

if lsof -i :8081 &> /dev/null; then
    echo "   ⚠️  Port 8081 is already in use"
    echo "      phpMyAdmin might already be running or port is occupied"
else
    echo "   ✅ Port 8081 (phpMyAdmin) is available"
fi

echo ""
echo "🎉 Setup validation complete!"
echo ""
echo "📋 Next steps:"
echo "   1. Run './start.sh' or 'docker compose up -d' to start the environment"
echo "   2. Wait a few moments for services to initialize"
echo "   3. Visit http://localhost:8080 to set up WordPress"
echo "   4. Activate the 'My First Plugin' from the WordPress admin"
echo ""
echo "📚 For detailed instructions, see README.md and LEARNING_GUIDE.md"