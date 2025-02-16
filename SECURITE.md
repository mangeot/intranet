# Sécuriser un serveur

- sudo a2enmod proxy proxy_http

## Bloquer les ports non nécessaires

- Vérifier les ports ouverts <https://fr.linux-console.net/?p=12058>

```bash
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
```

- Avec un NAT, n'ajouter que les règles nécessaires, pas de DMZ
- sur debian, désactiver avahi (mDNS), port 5353 et CUPS (service d'impression), port 631

```bash
 sudo systemctl disable --now avahi-daemon
 sudo systemctl disable --now cups 
 ```

- voir aussi le port 25 avec exim4, mais on a besoin d'un minimum de mail...

## Changer le port ssh par défaut

- Éditer /etc/ssh/sshd_config et changer Port=22 en Port=xxxx

## Sécuriser Apache

- installer certbot pour https
- supprimer les instructions cgi dans les configs

```text
`# ScriptAlias /cgi-bin/ /usr/lib/cgi-bin/
`#  <Directory "/usr/lib/cgi-bin">
```

- supprimer la signature dans /etc/apache2/apache2.conf

```text
   ServerSignature Off
   ServerTokens Prod
```

- ajouter des hôtes catch-all pour les requêtes par adresse IP
Ce sont les pirates !

```text
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

```bash
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

## Installer un serveur DNS

- installer dig avec sudo apt install dnsutils
- installer Unbound sudo apt install unbound :
<https://www.howtoforge.com/how-to-set-up-local-dns-with-unbound-on-debian/>
voir unbound.conf
- installer systemd-resolved:
<https://serverfault.com/questions/1145358/how-can-i-configure-my-dns-settings-on-debian-12>
sudo apt install systemd-resolved
sudo vi /etc/systemd/resolved.conf

```text
[Resolve]
DNS=192.168.1.25 2a02:842b:6c02:5501:967a:c85e:a776:abcd
FallbackDNS=8.8.8.8 8.8.4.4 2001:4860:4860::8888 2001:4860:4860::8844
```
