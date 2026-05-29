#!/bin/sh

MOVIE_ID="$1"

if [ -z "$MOVIE_ID" ]; then
    echo "Usage: $0 <imdb_id>" >&2
    exit 1
fi

API_KEY="${OMDB_API_KEY:-}"

if [ -z "$API_KEY" ]; then
    echo "OMDB_API_KEY is required" >&2
    exit 1
fi

if ! RESPONSE=$(curl -fsS \
    "https://www.omdbapi.com/?i=$MOVIE_ID&apikey=$API_KEY"); then
    echo "Failed to fetch movie data" >&2
    exit 1
fi

if ! TITLE=$(printf '%s\n' "$RESPONSE" | jq -er 'select(.Response == "True") | .Title // empty'); then
    echo "Movie title not found" >&2
    exit 1
fi

printf '%s\n' "$TITLE"
