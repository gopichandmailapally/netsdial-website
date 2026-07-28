#!/bin/bash
# ══════════════════════════════════════════════════════════════
#  NetsDial – VPS Auto-Deploy Script
#  Ubuntu 24/26 | Apache + PHP 8.2 + MySQL 8
#  Run as root: bash setup-vps.sh
# ══════════════════════════════════════════════════════════════

set -e

# ── Config ──────────────────────────────────────────────────
DOMAIN="netsdial.com"
WEBROOT="/var/www/netsdial"
DB_NAME="netsdial_db"
DB_USER="netsdial_user"
DB_PASS="NetsDial@2025!"
GITHUB_REPO="https://github.com/YOUR_GITHUB_USERNAME/netsdial-website.git"

RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; NC='\033[0m'
log()  { echo -e "${GREEN}[✓]${NC} $1"; }
warn() { echo -e "${YELLOW}[!]${NC} $1"; }
err()  { echo -e "${RED}[✗]${NC} $1"; exit 1; }

echo ""
echo "══════════════════════════════════════════════"
echo "   NetsDial VPS Setup – Starting..."
echo "══════════════════════════════════════════════"
echo ""

# ── 1. System Update ─────────────────────────────────────────
log "Updating system packages..."
apt-get update -qq && apt-get upgrade -y -qq

# ── 2. Install Apache ────────────────────────────────────────
log "Installing Apache2..."
apt-get install -y -qq apache2
a2enmod rewrite headers deflate expires ssl
systemctl enable apache2

# ── 3. Install PHP 8.2 ───────────────────────────────────────
log "Installing PHP 8.2..."
apt-get install -y -qq software-properties-common
add-apt-repository ppa:ondrej/php -y
apt-get update -qq
apt-get install -y -qq \
  php8.2 php8.2-mysql php8.2-curl php8.2-gd php8.2-mbstring \
  php8.2-xml php8.2-zip php8.2-intl php8.2-opcache \
  libapache2-mod-php8.2

# ── 4. Install MySQL ─────────────────────────────────────────
log "Installing MySQL 8..."
apt-get install -y -qq mysql-server mysql-client

# Secure MySQL
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'MySQL@Root2025!';" 2>/dev/null || true
mysql -uroot -p'MySQL@Root2025!' -e "DELETE FROM mysql.user WHERE User='';" 2>/dev/null || true
mysql -uroot -p'MySQL@Root2025!' -e "DROP DATABASE IF EXISTS test;" 2>/dev/null || true
mysql -uroot -p'MySQL@Root2025!' -e "FLUSH PRIVILEGES;" 2>/dev/null || true

# Create app database and user
log "Creating database: $DB_NAME"
mysql -uroot -p'MySQL@Root2025!' -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -uroot -p'MySQL@Root2025!' -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';"
mysql -uroot -p'MySQL@Root2025!' -e "GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'localhost';"
mysql -uroot -p'MySQL@Root2025!' -e "FLUSH PRIVILEGES;"

# ── 5. Install Git ───────────────────────────────────────────
log "Installing Git..."
apt-get install -y -qq git

# ── 6. Clone / Pull Repository ───────────────────────────────
log "Setting up website directory: $WEBROOT"
mkdir -p $WEBROOT

if [ -d "$WEBROOT/.git" ]; then
  warn "Repo exists — pulling latest..."
  cd $WEBROOT && git pull origin main
else
  warn "Cloning repository..."
  git clone $GITHUB_REPO $WEBROOT
fi

# ── 7. Configure database.php ────────────────────────────────
log "Configuring database connection..."
sed -i "s/netsdial_user/$DB_USER/g"  $WEBROOT/config/database.php
sed -i "s/NetsDial@2025!/$DB_PASS/g" $WEBROOT/config/database.php
sed -i "s/netsdial_db/$DB_NAME/g"    $WEBROOT/config/database.php

# ── 8. Import Database Schema ────────────────────────────────
log "Importing database schema..."
mysql -u$DB_USER -p$DB_PASS $DB_NAME < $WEBROOT/install/schema.sql
log "Database imported!"

# ── 9. File Permissions ───────────────────────────────────────
log "Setting file permissions..."
chown -R www-data:www-data $WEBROOT
find $WEBROOT -type d -exec chmod 755 {} \;
find $WEBROOT -type f -exec chmod 644 {} \;
chmod 777 $WEBROOT/uploads/gallery
chmod 777 $WEBROOT/uploads/sliders
chmod 777 $WEBROOT/uploads/blogs
chmod 777 $WEBROOT/uploads/logos

# ── 10. Apache VirtualHost ──────────────────────────────────
log "Configuring Apache VirtualHost..."
cat > /etc/apache2/sites-available/netsdial.conf << VHOST
<VirtualHost *:80>
    ServerName $DOMAIN
    ServerAlias www.$DOMAIN
    DocumentRoot $WEBROOT

    <Directory $WEBROOT>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # PHP Settings
    php_value upload_max_filesize 32M
    php_value post_max_size 32M
    php_value max_execution_time 300
    php_value memory_limit 256M

    # Logs
    ErrorLog  \${APACHE_LOG_DIR}/netsdial_error.log
    CustomLog \${APACHE_LOG_DIR}/netsdial_access.log combined
</VirtualHost>
VHOST

# Enable site
a2dissite 000-default.conf 2>/dev/null || true
a2ensite netsdial.conf
systemctl restart apache2

# ── 11. Install Certbot (Free SSL) ──────────────────────────
log "Installing Certbot for free SSL..."
apt-get install -y -qq certbot python3-certbot-apache
warn "Run this after pointing domain DNS to this server:"
warn "  certbot --apache -d $DOMAIN -d www.$DOMAIN"

# ── 12. PHP OPcache Config ──────────────────────────────────
log "Optimizing PHP OPcache..."
cat > /etc/php/8.2/apache2/conf.d/netsdial-opcache.ini << PHP
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
PHP
service apache2 restart

# ── 13. Firewall ─────────────────────────────────────────────
log "Configuring UFW firewall..."
ufw allow OpenSSH
ufw allow 'Apache Full'
ufw --force enable

# ── Done! ────────────────────────────────────────────────────
echo ""
echo "══════════════════════════════════════════════════════"
echo -e "${GREEN}  NetsDial VPS Setup Complete!${NC}"
echo "══════════════════════════════════════════════════════"
echo ""
echo "  Website Root  : $WEBROOT"
echo "  Database Name : $DB_NAME"
echo "  DB Username   : $DB_USER"
echo "  DB Password   : $DB_PASS"
echo ""
echo "  Admin Panel   : http://$DOMAIN/admin"
echo "  Admin Login   : admin / password"
echo ""
echo -e "${RED}  ⚠ IMPORTANT: Change admin password immediately!${NC}"
echo ""
