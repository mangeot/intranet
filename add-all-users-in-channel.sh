#!/bin/sh

docker exec -ti intranet-mattermost-1 mmctl --local channel users add emanciper-sympathisants:$1 $(
    docker exec -ti intranet-mattermost-1 mmctl --local user list --all --json 2>/dev/null | sed '$d' | jq -r '.[] | select(.delete_at == 0) | .username' | xargs
)
