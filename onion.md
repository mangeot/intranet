# ONION

<https://community.torproject.org/onion-services/setup/>

<https://community.torproject.org/onion-services/setup/install/>

<https://support.torproject.org/apt/tor-deb-repo/>

## Récupérer la clé de l'entrepôt tor

```bash
sudo wget -qO- https://deb.torproject.org/torproject.org/A3C4F0F979CAA22CDBA8F512EE8CBC9E886DDD89.asc | gpg --dearmor | sudo tee /usr/share/keyrings/deb.torproject.org-keyring.gpg >/dev/null

apt update
apt install tor deb.torproject.org-keyring

vi /etc/tor/torrc
```

HiddenServiceDir /var/lib/tor/mangeot_hidden_service/
HiddenServicePort 80 127.0.0.1:80

sudo systemctl restart tor

Installer et lancer tor browser ou Brave avec bridge depuis la France

### Configurer un vhost avec apache

/etc/apache/sites-available/onion-mangeot.conf

```text
<VirtualHost *:80>
       ServerName 7mggg52q4afboywe7i27zin7elzi6dcbfscuowthh7j7zlqbfwzvhgid.onion
       DocumentRoot /home/mangeot/onion_html
    <Directory />
        Options +FollowSymLinks
    </Directory>
    <Directory /home/mangeot/onion_html>
        Options +Indexes +FollowSymLinks +MultiViews
        AllowOverride all
        Require all granted
    </Directory>

       ErrorLog ${APACHE_LOG_DIR}/onion-mangeot_error.log
       CustomLog ${APACHE_LOG_DIR}/onion-mangeot_access.log combined
     </VirtualHost>
```

```bash
sudo a2ensite onion-mangeot
sudo systemctl apache2 restart
```
