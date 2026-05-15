#!/bin/bash
# ==========================================================
# SETUP COMPLETO NGINX + PHP + FTPS
# Debian 12 - Servidor no IP: 191.252.220.154
# FTP funcional na pasta /srv
# ==========================================================

set -e

# --------------------------
# VARIÁVEIS
# --------------------------
IP_PUBLICO="191.252.220.154"
FTP_USER="ftpuser"
FTP_PASS="SenhaSegura123!"
WEB_ROOT="/srv"
PASV_MIN=30000
PASV_MAX=30100
FTPS_CERT="/etc/ssl/certs/vsftpd.pem"

# --------------------------
# ATUALIZAR SISTEMA
# --------------------------
apt update -y
apt upgrade -y
apt install -y nginx php8.2-fpm vsftpd openssl ufw nano curl

systemctl enable --now nginx
systemctl enable --now php8.2-fpm

# --------------------------
# CRIAR DIRETÓRIO WEB
# --------------------------
mkdir -p $WEB_ROOT
chown -R $FTP_USER:$FTP_USER $WEB_ROOT 2>/dev/null || true
chmod -R 755 $WEB_ROOT

# --------------------------
# CRIAR USUÁRIO FTP
# --------------------------
if id "$FTP_USER" &>/dev/null; then
    echo "Usuário $FTP_USER já existe. Atualizando senha..."
    echo "$FTP_USER:$FTP_PASS" | chpasswd
else
    adduser --home $WEB_ROOT --shell /bin/bash --disabled-password --gecos "" $FTP_USER
    echo "$FTP_USER:$FTP_PASS" | chpasswd
fi

chown $FTP_USER:$FTP_USER $WEB_ROOT
chmod 755 $WEB_ROOT

# --------------------------
# CONFIGURAR VSFTPD (FTPS)
# --------------------------
# Criar certificado autoassinado
if [ ! -f "$FTPS_CERT" ]; then
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout $FTPS_CERT -out $FTPS_CERT \
        -subj "/C=BR/ST=SP/L=SaoPaulo/O=Servidor/CN=$IP_PUBLICO"
fi

# Backup config
cp /etc/vsftpd.conf /etc/vsftpd.conf.bak

cat > /etc/vsftpd.conf <<EOF
listen=YES
listen_ipv6=NO
anonymous_enable=NO
local_enable=YES
write_enable=YES
local_umask=022
dirmessage_enable=YES
use_localtime=YES
xferlog_enable=YES
connect_from_port_20=YES
chroot_local_user=YES
allow_writeable_chroot=YES
pasv_enable=YES
pasv_min_port=$PASV_MIN
pasv_max_port=$PASV_MAX
ssl_enable=YES
rsa_cert_file=$FTPS_CERT
force_local_data_ssl=YES
force_local_logins_ssl=YES
ssl_tlsv1_2=YES
ssl_sslv2=NO
ssl_sslv3=NO
require_ssl_reuse=NO
seccomp_sandbox=NO
local_root=$WEB_ROOT
EOF

systemctl daemon-reload
systemctl restart vsftpd
systemctl enable vsftpd

# --------------------------
# CONFIGURAÇÃO NGINX
# --------------------------
cat > /etc/nginx/sites-available/default <<EOF
server {
    listen 80;
    server_name $IP_PUBLICO;

    root $WEB_ROOT;
    index index.html index.php;

    location / {
        try_files \$uri \$uri/ /index.html;
    }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }
}
EOF

nginx -t
systemctl reload nginx

# --------------------------
# CONFIGURAÇÃO FIREWALL
# --------------------------
ufw allow 22/tcp   # SSH
ufw allow 21/tcp   # FTP
ufw allow 80/tcp   # HTTP
ufw allow 443/tcp  # HTTPS
ufw allow $PASV_MIN:$PASV_MAX/tcp  # PASV FTPS
ufw --force enable

# --------------------------
# FINAL
# --------------------------
echo "========================================"
echo "✅ SERVIDOR COMPLETO NGINX + PHP + FTPS PRONTO"
echo "IP: $IP_PUBLICO"
echo "FTP (FTPS): ftps://$FTP_USER@$IP_PUBLICO"
echo "Diretório raiz: $WEB_ROOT"
echo "Portas PASV: $PASV_MIN-$PASV_MAX"
echo "HTTP: http://$IP_PUBLICO"
echo "========================================"
