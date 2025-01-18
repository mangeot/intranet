# README

## .
- chmod -R 777 mattermost

## compose.yml
- déterminer son adresse IP (sur mac cliquer en haut à droite sur le wifi)
- NEXTCLOUD_TRUSTED_DOMAINS=
- MM_SERVICESETTINGS_SITEURL=http://localhost:8065
- server_name=

## LDAP
- https://localhost:10443/
- login DN : cn=admin,dc=emanciper,dc=org
- password : voir le .env

## Nextcloud
- https://localhost:8080/

### Pour initialiser Nextcloud :
- s'identifier en tant qu'administrateur (voir .env)
- cliquer en haut à droite puis sur Apps 
- activer l'app LDAP user and group backend
- cliquer en haut à droite puis sur Administration settings
- cliquer dans la colonne de gauche sur LDAP/AD integration
- déterminer son adresse IP (sur mac cliquer en haut à droite sur le wifi)
- User DN : cn=admin,dc=emanciper,dc=org
- Password : voir .env
- One base DN per line : ou=membreactif,dc=emanciper,dc=org

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
- Bind Username: cn=admin,dc=emanciper,dc=org
- Bind Password : voir .env
- Base DN: ou=membreactif,dc=emanciper,dc=org

- ajouter l'app NextCloud
J'ai pas réussi à l'ajouter : pb de connexion au marketplace
Voir le code : https://github.com/mattermost-community/mattermost-app-nextcloud

### Pour configurer Mattermost ensuite :
- récupérer son adresse IP (via le wifi)
- modifier mattermost/configconfig.json
    "LdapServer": "x.x.x.x",

## Startup script
LAncer create-docker-compose-service.sh

## TODO
- régler l'intégration MM/NC
- penser à une sauvegarde automatique avec cron et rsync ou scp...
