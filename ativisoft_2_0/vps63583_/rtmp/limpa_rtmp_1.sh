#!/bin/bash
set -e

echo "==============================="
echo " LIMPEZA NGINX-RTMP"
echo "==============================="

# Diretórios
SNAPSHOTS="/srv/rtmp/snapshots"
HLS="/srv/rtmp/hls"
NGINX_LOG="/var/log/nginx"
NGINX_CACHE="/var/cache/nginx"
NGINX_LIB="/var/lib/nginx"
TMP="/tmp"

echo ""
echo ">>> Espaço ANTES da limpeza"
du -sh $SNAPSHOTS $HLS $NGINX_LOG $NGINX_CACHE $NGINX_LIB $TMP 2>/dev/null || true

echo ""
echo ">>> Limpando snapshots..."
find $SNAPSHOTS -type f -delete 2>/dev/null || true

echo ">>> Limpando HLS (.ts e .m3u8)..."
find $HLS -type f \( -name "*.ts" -o -name "*.m3u8" \) -delete 2>/dev/null || true

echo ">>> Limpando cache do NGINX..."
find $NGINX_CACHE -type f -delete 2>/dev/null || true

echo ">>> Limpando temporários do NGINX..."
find $NGINX_LIB -type f -delete 2>/dev/null || true

echo ">>> Limpando logs do NGINX (truncate, sem parar serviço)..."
for log in $NGINX_LOG/*.log; do
    [ -f "$log" ] && truncate -s 0 "$log"
done

echo ">>> Limpando arquivos temporários antigos (>1 dia) em /tmp..."
find $TMP -type f -mtime +1 -delete 2>/dev/null || true

echo ""
echo ">>> Espaço DEPOIS da limpeza"
du -sh $SNAPSHOTS $HLS $NGINX_LOG $NGINX_CACHE $NGINX_LIB $TMP 2>/dev/null || true

echo ""
echo "✅ Limpeza concluída com sucesso"
