#!/bin/bash

# Testear API desde consola. Ejecuta GET/POST con curl y muestra JSON

API_URL="http://localhost/anonimas/proyectoTres/api.php"

echo "🚀 Testeando API REST - Conversaciones Anónimas"
echo "=========================================="
echo

show_response() {
    echo "📋 Respuesta:"
    echo "$1" | python3 -m json.tool 2>/dev/null || echo "$1"
    echo
    echo "---"
    echo
}

# 1. GET - Listar todas las conversaciones
echo "1️⃣ GET - Listar todas las conversaciones"
response=$(curl -s -X GET "$API_URL/conversaciones")
show_response "$response"

# 2. POST - Crear nueva conversación
echo "2️⃣ POST - Crear nueva conversación"
response=$(curl -s -X POST "$API_URL/conversaciones" \
  -H "Content-Type: application/json" \
  -d '{"password":"123"}')
show_response "$response"

CODIGO=$(echo "$response" | python3 -c "import sys, json; print(json.load(sys.stdin)['codigo'])" 2>/dev/null)

# 3. GET - Verificar conversación creada
echo "3️⃣ GET - Verificar conversación creada"
response=$(curl -s -X GET "$API_URL/conversaciones/$CODIGO")
show_response "$response"

echo "✅ Test completado!"
