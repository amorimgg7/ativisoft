#!/bin/bash
# ============================================================
# Script FTP para pasta /srv do Nginx
# Sistema: Debian/Ubuntu (VPS sem ufw)
# Servidor FTP: vsftpd
# Porta FTP padrão: 21
# Portas PASV: 30000-30100
# Usuário dedicado: ftpuser
# ============================================================

# ---------- 1️⃣ Atualizar pacotes ----------
sudo apt update && sudo apt upgrade -y

# ---------- 2️⃣ Instalar vsftpd ----------
sudo apt install vsftpd ssl-cert -y

# ---------- 3️⃣ Criar usuário FTP ----------
FTP_USER="ftpuser"
FTP_PASS="SenhaSegura123!"   # Troque para uma senha segura

# Se usuário já existir, apenas ajuste a senha
if id "$FTP_USER" &>/dev/null; then
    echo "Usuário $FTP_USER já existe. Atualizando senha..."
    echo "$FTP_USER:$FTP_PASS" | sudo chpasswd
else
    echo "Criando usuário $FTP_USER..."
    sudo adduser --home /srv --shell /bin/bash --disabled-password --gecos "" $FTP_USER
    echo "$FTP_USER:$FTP_PASS" | sudo chpasswd
fi

# ---------- 4️⃣ Ajustar permissões da pasta /srv ----------
sudo chown $FTP_USER:$FTP_USER /srv
sudo chmod 755 /srv
# Caso queira permitir upload, use chmod 775
# sudo chmod 775 /srv

# ---------- 5️⃣ Configurar vsftpd ----------
sudo cp /etc/vsftpd.conf /etc/vsftpd.conf.bak

sudo bash -c 'cat > /etc/vsftpd.conf <<EOF
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
pasv_min_port=30000
pasv_max_port=30100
seccomp_sandbox=NO
EOF'

# ---------- 6️⃣ Reiniciar vsftpd ----------
sudo systemctl restart vsftpd
sudo systemctl enable vsftpd

# ---------- 7️⃣ Configurar firewall com iptables ----------
sudo iptables -A INPUT -p tcp --dport 21 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 30000:30100 -j ACCEPT
sudo iptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -j ACCEPT

# Salvar regras para reinício
sudo apt install iptables-persistent -y
sudo netfilter-persistent save

# ---------- 8️⃣ Informações finais ----------
echo "=========================================================="
echo "Servidor FTP configurado com sucesso!"
echo "Usuário: $FTP_USER"
echo "Senha: $FTP_PASS"
echo "Diretório root: /srv"
echo "Porta FTP: 21"
echo "Portas PASV: 30000-30100"
echo "=========================================================="
