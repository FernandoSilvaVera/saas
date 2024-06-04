#!/bin/bash

# Comando que quieres verificar
COMMAND="php artisan queue:work --daemon --tries=3 --timeout=900 --memory=2048"

# Busca el proceso
pgrep -f "$COMMAND" > /dev/null

# Si el proceso no está en ejecución, vuelve a ejecutarlo
if [ $? -ne 0 ]; then
    echo "Process not found. Restarting..."
    nohup $COMMAND > /dev/null 2>&1 &
else
    echo "Process is running."
fi
