#!/bin/bash
set -e

# Shebang: Indica que el script debe ser interpretado por el shell de Bash. Es una convención para que el sistema sepa qué intérprete usar para ejecutar el script.

#set -e: Hace que el script se detenga inmediatamente si cualquier comando devuelve un estado de error (un código de salida distinto de cero). 
# Esto ayuda a evitar la continuación de la ejecución del script si algo falla.

# ======================= Variables de entorno ============================
# ESTAS SCRIPT SE EJECUTA JUSTO CUANDO EL docker-compose EMPIEZA A HACER LA BD
# Estas variables de entorno ya están declaradas en ese documento.

MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:-root_password}
MYSQL_DATABASE=${MYSQL_DATABASE:-tfg_ilian_docker_compose}
MYSQL_USER=${MYSQL_USER:-usuario}
MYSQL_PASSWORD=${MYSQL_PASSWORD:-a}

# Inicializa la base de datos y crea el usuario
mariadb -u root -p${MYSQL_ROOT_PASSWORD} <<-EOSQL
    DROP DATABASE IF EXISTS \`${MYSQL_DATABASE}\`;
    CREATE DATABASE \`${MYSQL_DATABASE}\`;
    CREATE USER IF NOT EXISTS '${MYSQL_USER}'@'%' IDENTIFIED BY '${MYSQL_PASSWORD}';
    GRANT ALL PRIVILEGES ON \`${MYSQL_DATABASE}\`.* TO '${MYSQL_USER}'@'%';
    FLUSH PRIVILEGES;
EOSQL

# Importa la base de datos
if [ -f /docker-entrypoint-initdb.d/BD_TFG_DOCKER_vFINAL_8-24-2024.sql ]; then
    mariadb -u root -p${MYSQL_ROOT_PASSWORD} ${MYSQL_DATABASE} < /docker-entrypoint-initdb.d/BD_TFG_DOCKER_vFINAL_8-24-2024.sql
fi
