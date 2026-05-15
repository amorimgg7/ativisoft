

INSERT INTO dispositivos (mac_dispositivo, status_dispositivo1) VALUES ('mac:mac:mac:mac:mac','status');

UPDATE dispositivos SET status_dispositivo1 = '1' WHERE mac_dispositivo = 'mac:mac:mac:mac:mac';

SELECT mac_dispositivo FROM dispositivos WHERE status_dispositivo1 = '1';
