#!/bin/bash
# ==========================================================
# YOLOv8 Lightweight API para eventos - CPU only
# Debian 12
# ==========================================================

set -e

# --------------------------
# VARIÁVEIS
# --------------------------
YOLO_DIR="/srv/yolo"
VENVDIR="$YOLO_DIR/venv"
CAMERAS="/srv/rtmp/hls"
SNAPSHOTS="/srv/rtmp/snapshots"
EVENTS="$YOLO_DIR/events"
PYTHON=$(which python3)
PIP=$(which pip3)

mkdir -p $YOLO_DIR $EVENTS

# --------------------------
# INSTALAÇÃO DO AMBIENTE LEVE
# --------------------------
apt update -y
apt install -y python3-venv python3-pip ffmpeg curl nano unzip

# Criar virtualenv
$PYTHON -m venv $VENVDIR
source $VENVDIR/bin/activate

# Atualizar pip e instalar pacotes leves
pip install --upgrade pip
pip install opencv-python-headless ultralytics==8.1.100 flask

# --------------------------
# SCRIPT DE DETECÇÃO (Python)
# --------------------------
cat > $YOLO_DIR/yolo_events.py <<'EOF'
import cv2
import os
import time
import json
from ultralytics import YOLO
from datetime import datetime

CAM_DIR = "/srv/rtmp/hls"
SNAP_DIR = "/srv/rtmp/snapshots"
EVENTS_DIR = "/srv/yolo/events"
MODEL_PATH = "yolov8n.pt"  # modelo leve

model = YOLO(MODEL_PATH)

while True:
    for f in os.listdir(CAM_DIR):
        if f.endswith(".m3u8"):
            cam_key = os.path.splitext(f)[0]
            snap_path = os.path.join(SNAP_DIR, f"{cam_key}.jpg")

            # Gerar snapshot
            os.system(f"ffmpeg -y -i {os.path.join(CAM_DIR,f)} -frames:v 1 -q:v 5 {snap_path} < /dev/null &> /dev/null")

            if os.path.exists(snap_path):
                img = cv2.imread(snap_path)
                if img is None:
                    continue

                results = model(img)

                for r in results:
                    if r.boxes is not None and len(r.boxes) > 0:
                        for box, cls in zip(r.boxes.xyxy, r.boxes.cls):
                            x1, y1, x2, y2 = map(int, box)
                            label = results.names[int(cls)]
                            # Draw box and label
                            cv2.rectangle(img, (x1, y1), (x2, y2), (0,255,0), 2)
                            cv2.putText(img, label, (x1, y1-5), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0,255,0), 2)
                            # Save event
                            event = {
                                "time": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
                                "cam": cam_key,
                                "object": label,
                                "image": f"/snapshots/{cam_key}.jpg"
                            }
                            ev_file = os.path.join(EVENTS_DIR, f"{cam_key}.txt")
                            with open(ev_file, "a") as ef:
                                ef.write(json.dumps(event) + "\n")
                            # global log
                            global_file = os.path.join(EVENTS_DIR, "all_events.txt")
                            with open(global_file, "a") as gf:
                                gf.write(json.dumps(event) + "\n")
                # Atualizar snapshot com boxes
                cv2.imwrite(snap_path, img)
    time.sleep(2)
EOF

# --------------------------
# FLASK API
# --------------------------
cat > $YOLO_DIR/api_events.py <<'EOF'
from flask import Flask, jsonify, request
import os, json

EVENTS_DIR = "/srv/yolo/events"
app = Flask(__name__)

# Todos eventos recentes
@app.route("/api_events.php")
def all_events():
    mode = request.args.get("mode","all")
    all_file = os.path.join(EVENTS_DIR, "all_events.txt")
    events = []
    if os.path.exists(all_file):
        with open(all_file) as f:
            for line in f:
                events.append(json.loads(line))
    if mode == "recent":
        events = events[-5:]
    return jsonify(events)

# Eventos por câmera
@app.route("/api_event.php/<cam_key>")
def cam_events(cam_key):
    cam_file = os.path.join(EVENTS_DIR, f"{cam_key}.txt")
    events = []
    if os.path.exists(cam_file):
        with open(cam_file) as f:
            for line in f:
                events.append(json.loads(line))
        events = events[-5:]
    return jsonify(events)

if __name__=="__main__":
    app.run(host="0.0.0.0", port=5001)
EOF

# --------------------------
# CRIAR SCRIPT DE SERVIÇO
# --------------------------
cat > /usr/local/bin/run_yolo_api.sh <<EOF
#!/bin/bash
source $VENVDIR/bin/activate
python3 $YOLO_DIR/yolo_events.py &
python3 $YOLO_DIR/api_events.py &
EOF

chmod +x /usr/local/bin/run_yolo_api.sh

# --------------------------
# EXECUTAR
# --------------------------
nohup /usr/local/bin/run_yolo_api.sh >/dev/null 2>&1 &

echo "======================================"
echo "✅ YOLOv8 CPU API PRONTA"
echo "API eventos recentes: https://vps63583.publiccloud.com.br:5001/api_events.php?mode=recent"
echo "API por câmera     : https://vps63583.publiccloud.com.br:5001/api_event.php/<cam_key>"
echo "Snapshots com boxes em: /srv/rtmp/snapshots"
echo "======================================"
