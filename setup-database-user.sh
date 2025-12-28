#!/bin/bash

echo "Membuat user database untuk SD Negeri Jomblang 2..."

# Login ke MySQL dan buat user
sudo mysql << EOF
-- Buat database
CREATE DATABASE IF NOT EXISTS sd_jomblang2;

-- Buat user khusus aplikasi
CREATE USER IF NOT EXISTS 'mustafa'@'localhost' IDENTIFIED BY 'moslem78';

-- Beri hak akses
GRANT ALL PRIVILEGES ON sd_jomblang2.* TO 'mustafa'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;
EOF

# Update file .env
cd /var/www/html/sd-jomblang2
cat > .env << EOL
APP_NAME="SD Negeri Jomblang 2"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sd_jomblang2
DB_USERNAME=mustafa
DB_PASSWORD=moslem78

# ... (config lainnya tetap sama)
EOL

echo "User database berhasil dibuat!"
echo "Username: mustafa"
echo "Password: moslem78"
