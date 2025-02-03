# Sécuriser un serveur
- sudo a2enmod proxy proxy_http

## Bloquer les ports non nécessaires
- Vérifier les ports ouverts https://fr.linux-console.net/?p=12058
```
 sudo apt install net-tools
 netstat -utln
    22 : ssh
    25 : mail
    80 : http
    123 : ntp (réglage de l'heure)
    443 : https
    631 : cups (service d'impression)
    3306 : mysql (base de données)
    5353 : avahi (multicast DNS)
    5432 : postgresql (base de données)

- Avec un NAT, n'ajouter que les règles nécessaires, pas de DMZ
- sur debian, désactiver avahi (mDNS), port 5353 et CUPS (service d'impression), port 631
```
 sudo systemctl disable --now avahi-daemon
 sudo systemctl disable --now cups 
 ```
 - voir aussi le port 25 avec exim4, mais on a besoin d'un minimum de mail...

## Changer le port ssh par défaut
- Éditer /etc/ssh/sshd_config et changer Port=22 en Port=xxxx

## Sécuriser Apache
- installer certbot pour https
- supprimer les instructions cgi dans les configs
```
# ScriptAlias /cgi-bin/ /usr/lib/cgi-bin/
#  <Directory "/usr/lib/cgi-bin">
```

- supprimer la signature dans /etc/apache2/apache2.conf 
```
ServerSignature Off
ServerTokens Prod
```

- ajouter des hôtes catch-all pour les requêtes par adresse IP
Ce sont les pirates !
```
<VirtualHost *:80>
	Redirect permanent / https://www.google.com 
</VirtualHost>

<VirtualHost *:443>
	ServerName catch-all
	SSLEngine on
	SSLCertificateFile      /etc/ssl/certs/ssl-cert-snakeoil.pem
	SSLCertificateKeyFile   /etc/ssl/private/ssl-cert-snakeoil.key

	Redirect permanent / https://www.google.com
</VirtualHost>
```

## installer Fail2ban
- après l'install, copier les configurations du sous-dossier fail2ban
sudo cp -R ./fail2ban/jail.d/* /etc/fail2ban/jail.d/. 
```
sudo apt install fail2ban
sudo systemctl start fail2ban
sudo systemctl enable fail2ban
sudo systemctl status fail2ban
sudo fail2ban-client status
sudo fail2ban-client status sshd
sudo fail2ban-client status apache-auth
sudo fail2ban-client banned
sudo fail2ban-client set sshd unbanip <ip-address>
```
