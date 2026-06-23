#!/bin/sh

docker exec -ti intranet-mattermost-1 mmctl --local channel users add emanciper:$1 $(
    docker exec -ti intranet-mattermost-1 mmctl --local user list --team emanciper --json 2>/dev/null | sed '$d' | jq -r '.[] | select(.delete_at == 0) | .username' | xargs
)
