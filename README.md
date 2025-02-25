# README

## `.

```bash
 vi ./ldap/bootstrap.ldif
 chmod -R 777 ./postgres
 mkdir -p ./mattermost/{config,data,logs,plugins,client/plugins,bleve-indexes}; chmod -R 777 ./mattermost/
 cp ./env ./.env
```

## `.env

```text
SERVER_NAME=intranet.myorganization.org
LDAP_BASE_DN="dc=myorganization,dc=org"
LDAP_ORGANISATION="My Organization"
LDAP_DOMAIN=myorganization.org
LDAP_ADMIN_PASSWORD=Adm1nPa55W0rd!
POSTGRES_USER_NAME=admin
POSTGRES_USER_PASSWORD=UserPa55W0rd!
NEXTCLOUD_ADMIN_USER=admin
NEXTCLOUD_ADMIN_PASSWORD=Adm1nPa55W0rd!
COLLABORA_USERNAME=collabora
COLLABORA_PASSWORD=Adm1nPa55W0rd!
````

## lancer docker

<https://docs.docker.com/engine/install/debian/>

```bash
 docker-compose up
```

## LDAP

- <https://localhost:10443/>
- login DN : cn=admin,${LDAP_BASE_DN}
- password : ${LDAP_ADMIN_PASSWORD}

## Nextcloud

- <https://localhost:8080/>

### Pour initialiser Nextcloud

- s'identifier en tant qu'administrateur (${NEXTCLOUD_ADMIN_USER} et ${NEXTCLOUD_ADMIN_PASSWORD})
- cliquer en haut à droite puis sur Apps
- cliquer en haut à gauche sur Your apps
- activer l'app LDAP user and group backend
- cliquer en haut à droite puis sur Administration settings
- cliquer dans la colonne de gauche sur LDAP/AD integration
- déterminer son adresse IP (sur mac cliquer en haut à droite sur le wifi)
    192.168.1.20
- User DN : cn=admin,${LDAP_BASE_DN}
- Password : ${LDAP_ADMIN_PASSWORD}
- One base DN per line : ou=membreactif,${LDAP_BASE_DN}

Pas possible de configurer sur jibiki

- ajouter l'app Integration -> Mattermost integration
J'ai pas réussi à la configurer, problème d'authentification...

Note : j'ai dû reconfigurer après redémarrage. Il doit y avoir quelque chose qui ne se sauvegarde pas. À tester...

- ajouter l'app Polls
- ajouter l'app Calendrier
- ajouter l'app Nextcloud office puis ouvrir
    https://{$SERVER_NAME}/settings/admin/richdocuments et ajouter
https://${COLLABORA_USERNAME}:${COLLABORA_USERNAME}@192.168.1.20:9980

### Pour configurer NextCloud ensuite

- récupérer son adresse IP (via le wifi)
- se connecter avec le compte admin
- cliquer en haut à droite puis sur Administration settings
- cliquer dans la colonne de gauche sur LDAP/AD integration

### Collabora

<https://techoverflow.net/2021/08/19/how-to-run-collabora-office-for-nextcloud-using-docker-compose/>
<https://sdk.collaboraonline.com/docs/installation/Proxy_settings.html#reverse-proxy-with-apache-2-webserver>

Voir plus tard pour sécurité : allow list for WOPI requests...

## Mattermost

<http://localhost:8065>

### Pour initialiser Mattermost

- Créer un compte admin
- Dans le menu de gauche, System console, Authentication, AD/LDAP, start trial
- Bind Username: cn=admin,${LDAP_BASE_DN}
- Bind Password : ${LDAP_ADMIN_PASSWORD}
- Base DN: ou=membreactif,${LDAP_BASE_DN}

### Pour configurer Mattermost ensuite

- Pour le plugin Calls, ouvrir le port 8443 en UDP depuis l'extérieur
  - voir le NAT
- récupérer son adresse IP publique (via le wifi)
- modifier mattermost/config/config.json

```text
    "LdapServer": "x.x.x.x",
    ...
    "tcpserveraddress": "x.x.x.x",
    ...
    "udpserveraddress": "x.x.x.x",
```

## bbb
```bash
$ git clone https://github.com/bigbluebutton/docker.$ git bbb-docker
$ cd bbb-docker
$ git checkout main 
$ ./scripts/setup
$ vi .env
$ ./scripts/generate-compose
$ docker compose up -d --no-build
```

### Compte admin
If you use greenlight, you can create an admin account with:
```bash
$ docker compose exec greenlight bundle exec rake admin:create
```

### NAT
Kurento binds somehow always to the external IP instead of the local one or `0.0.0.0`. For that reason you need to add your external IP to your interface.

#### Temporary  way (until next reboot)
```
$ ip addr add 77.129.46.124/30 dev enp2s0
```
### Mattermost bbb plugin
https://github.com/blindsidenetworks/mattermost-plugin-bigbluebutton/blob/master/README.md#installation-and-setup
Copier le SHARED_SECRET du .env dans la config

### NextCloud bbb plugin
Copier le SHARED_SECRET du .env dans la config

## Startup script
Pas besoin car docker redémarre les containers !
Lancer create-docker-compose-service.sh

## Sauvegarde automatique

## TODO
- régler le pb de collabora sur le même serveur
- on ne peut pas se connecter directement à bbb
