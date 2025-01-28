# README

## .
- mkdir mattermost;chmod -R 777 mattermost

## .env
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

## lancer docker
https://docs.docker.com/engine/install/debian/
```

 docker-compose up
``` 

## LDAP
- https://localhost:10443/
- login DN : cn=admin,${LDAP_BASE_DN}
- password : ${LDAP_ADMIN_PASSWORD}

## Nextcloud
- https://localhost:8080/

### Pour initialiser Nextcloud :
- s'identifier en tant qu'administrateur (${NEXTCLOUD_ADMIN_USER} et ${NEXTCLOUD_ADMIN_PSSWORD})
- cliquer en haut à droite puis sur Apps 
- activer l'app LDAP user and group backend
- cliquer en haut à droite puis sur Administration settings
- cliquer dans la colonne de gauche sur LDAP/AD integration
- déterminer son adresse IP (sur mac cliquer en haut à droite sur le wifi)
- User DN : cn=admin,${LDAP_BASE_DN}
- Password : ${LDAP_ADMIN_PASSWORD}
- One base DN per line : ou=membreactif,${LDAP_BASE_DN}

Pas possible de configurer sur jibiki

- ajouter l'app Integration -> Mattermost integration
J'ai pas réussi à la configurer, problème d'authentification...

Note : j'ai dû reconfigurer après redémarrage. Il doit y avoir quelque chose qui ne se sauvegarde pas. À tester...

- ajouter l'app Polls
- ajouter l'app collabora office
- ajouter l'app d'agenda

### Pour configurer NextCloud ensuite :
- récupérer son adresse IP (via le wifi)
- se connecter avec le compte admin
- cliquer en haut à droite puis sur Administration settings
- cliquer dans la colonne de gauche sur LDAP/AD integration

### Collabora
https://techoverflow.net/2021/08/19/how-to-run-collabora-office-for-nextcloud-using-docker-compose/
https://sdk.collaboraonline.com/docs/installation/Proxy_settings.html#reverse-proxy-with-apache-2-webserver

## Mattermost
### Pour initialiser Mattermost :
- Créer un compte admin
- Dans le menu de gauche, System console, Authentication, AD/LDAP, start trial
- Bind Username: cn=admin,${LDAP_BASE_DN}
- Bind Password : ${LDAP_ADMIN_PASSWORD}
- Base DN: ou=membreactif,${LDAP_BASE_DN}

- ajouter l'app NextCloud
J'ai pas réussi à l'ajouter : pb de connexion au marketplace
Voir le code : https://github.com/mattermost-community/mattermost-app-nextcloud

### Pour configurer Mattermost ensuite :
- récupérer son adresse IP (via le wifi)
- modifier mattermost/config/config.json
    "LdapServer": "x.x.x.x",

## Startup script
Lancer create-docker-compose-service.sh

## TODO
- régler l'intégration MM/NC
- penser à une sauvegarde automatique avec cron et rsync ou scp...
