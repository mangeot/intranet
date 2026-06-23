#!/bin/sh

docker exec -ti intranet-mattermost-1 mmctl --local channel list emanciper > channels-emanciper 
docker exec -ti intranet-mattermost-1 mmctl --local channel list emanciper-sympathisants > channels-emanciper-sympathisants 
sed -i '$d' channels-emanciper
sed -i '$d' channels-emanciper-sympathisants
cat channels-emanciper | while read line 
do
   # do something with $line here
   line=$(echo -n "$line" | tr -d '[\n\r]')
   case "$line" in
    *"(archived)"*)
      echo "❌ (archived)"
      ;;
    "town-square")
      echo "❌ ts found"
      ;;
    "moyens-informatiques")
      echo "❌ mi found"
      ;;
    "")
      echo "❌ vide"
      ;;
    *)
      echo "✅ on ajoute $1 à $line"
#      docker exec -ti intranet-mattermost-1 mmctl --local users add emanciper:$line $1 
      ;;
   esac
done
