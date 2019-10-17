#eliminar padron_reducido_ruc.txt
sudo rm -r /home/ubuntu/padron/padron_reducido_ruc.txt
#descargar http://www2.sunat.gob.pe/padron_reducido_ruc.zip
sudo wget http://www2.sunat.gob.pe/padron_reducido_ruc.zip -P /home/ubuntu/padron
# sudo curl http://www2.sunat.gob.pe/padron_reducido_ruc.zip > /home/ubuntu/padron/padron_reducido_ruc.zip
#descomprimir padron_reducido_ruc.zip
sudo unzip /home/ubuntu/padron/padron_reducido_ruc.zip -d /home/ubuntu/padron/
#eliminar padron_reducido_ruc.zip
sudo rm -r /home/ubuntu/padron/padron_reducido_ruc.zip
#corre sunat.rb
sudo ruby /home/ubuntu/padron/sunat.rb