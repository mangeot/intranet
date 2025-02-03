#!/usr/bin/bash

# database backup
/usr/bin/docker exec -t intranet-postgres-1 pg_dumpall -c -U postgres | /usr/bin/bzip2 --best > /home/mangeot/intranet/postgres/backups/dump_`date +%Y-%m-%d"_"%H_%M_%S`.sql.bz2

# rsync all files to mangeot.org
/usr/bin/rsync -avPz --delete -e 'ssh -p 2025 -i /home/mangeot/.ssh/id_rsa' /home/mangeot/intranet/* mangeot@mangeot.org:/home/mangeot/intranet/. >> /home/mangeot/intranet/sauvegarde.logs 2>&1

# rsync all files to jibiki.fr
/usr/bin/rsync -avPz --delete -e 'ssh -p 4807 -i /home/mangeot/.ssh/id_rsa' /home/mangeot/intranet/* mangeot@jibiki.fr:/home/mangeot/intranet/. >> /home/mangeot/intranet/sauvegarde.logs 2>&1
