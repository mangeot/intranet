# réglage de problèmes avec Collabora

## Contexte
À lire : 
<https://help.nextcloud.com/t/collabora-integration-guide/151879>
<https://sdk.collaboraonline.com/docs/installation/Collabora_Online_Troubleshooting_Guide.html#checking-network-connectivity-between-collabora-online-and-the-wopi-host>
I have nexcloud and collabora servers installed via docker.
My problem is that when I connect to nextcloud and collabora with my local network IP addresses (192.168.1.x), I can edit .doc files with no problems, but when I connect via public IP addresses and apache proxy, it fails with this error message: Result: Document loading failed Failed to load Nextcloud Office - please try again later
Even if I can see the connection on Collabora admin interface.

## Configuration:
- Debian GNU/Linux 12 (bookworm)
- Apache/2.4.62
- Nextcloud latest docker image: 30.0.5
- Collabora/code latest docker image: 24.04.12.2.1

## First scenario that works:
1.
Runs on local network with these two docker containers:
docker run -d -p 8080:80 nextcloud
docker run -t -d -p 9980:9980 -e "extra_params=--o:ssl.enable=false" -e "username=admin" -e "password=secret" collabora/code

http://192.168.1.89:8080/settings/admin/richdocuments displays:

> Collabora Online server is reachable.
> Collabora Online Development Edition 24.04.12.1 663fe346b8
> URL used by the browser: http://192.168.1.89:9980
> Nextcloud URL used by Collabora: http://192.168.1.89:8080 (Determined from the browser URL)

The result is OK

But when I try with public IPs, it fails:

## Here are the two configuration that do not work:
2.
Runs with public servers:
Reverse proxy settings in Apache2 config (SSL termination): https://sdk.collaboraonline.com/docs/installation/Proxy_settings.html
Launched these two containers:
```bash
docker run -d -p 8080:80 -v nextcloud:/var/www/html nextcloud
docker run -t -d -p 9980:9980 -e "extra_params=--o:ssl.enable=false --o:ssl.termination=true" -e "username=admin" -e "password=secret" -e "server_name=office.mydomain.org" -e "aliasgroup1=https://.*:443" collabora/code
```
3.
Runs with public servers:
Configured collabora server with an apache proxy (SSL): https://sdk.collaboraonline.com/docs/installation/Proxy_settings.html
Launched these two containers:
```bash
docker run -d -p 8080:80 -v nextcloud:/var/www/html nextcloud
docker run -t -d -p 9980:9980 -e "extra_params=--o:ssl.enable=true" -e "username=admin" -e "password=secret" -e "server_name=office.mydomain.org" -e "aliasgroup1=https://.*:443" collabora/code
```

2. and 3. give the same results:

> Collabora Online server is reachable.
> Collabora Online Development Edition 24.04.12.1 663fe346b8
> URL used by the browser: https://office.mydomain.org
> Nextcloud URL used by Collabora: https://intranet.mydomain.org (Determined from the browser URL)
Disable certificate verification

On https://office.mydomain.org/browser/dist/admin/admin.html I can see the connection with 1 user online, 1 document open

> Result: Document loading failed
> Failed to load Nextcloud Office - please try again later

### Troubleshooting
1. From the client, verify access to the Nextcloud UI 
```bash
$ curl https://intranet.emanciper.org/status.php -vvv  
```
2. From the client, verify access to Collabora 
```bash
$ curl https://office.emanciper.org/hosting/discovery -vvv  
```
3. from Nextcloud, verify access to Collabora
```bash
$ docker exec -it intranet-nextcloud-1 curl https://office.emanciper.org/hosting/discovery -vvv   
```
4. from Collabora, verify access to the Nextcloud UI
```bash
docker exec -it intranet-code-1 curl https://intranet.emanciper.org/status.php -vvv  
```
5. Check Collabora admin interface
<https://office.emanciper.org/browser/dist/admin/admin.html> 
Login: ${COLLABORA_USER}
Password: ${COLLABORA_PASSWORD}
6. Checking network connectivity between Collabora Online and the WOPI host
```bash
$ curl -i https://office.emanciper.org/hosting/wopiAccessCheck --header "Content-Type: application/json" -d '{"callbackUrl":"https://wopi-host.local:8443"}'
```
Does not work...

Apache error logs for both servers are empty
Apache access logs for both servers show only http 200 responses codes
Nextcloud /var/www/html/data/nextcloud.log is empty even with loglevel 0
```bash
docker logs intranet-nextcloud-1
```
 gives only http 200 responses codes
```bash
docker logs intranet-code-1
```
gives these 3 different error lines:

```text
[ coolwsd ] WRN  Waking up dead poll thread [main], started: false, finished: false| net/Socket.hpp:824
[ forkit ] WRN  The systemplate directory [/opt/cool/systemplate] is read-only, and at least [/opt/cool/systemplate//etc/hosts] is out-of-date. Will have to clone dynamic elements of systemplate to the jails. To restore optimal performance, make sure the files in [/opt/cool/systemplate/etc] are up-to-date.| common/JailUtil.cpp:587
sh: 1: /usr/bin/coolmount: Operation not permitted
```
