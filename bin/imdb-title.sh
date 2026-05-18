#!/bin/sh

MOVIE_ID="$1"

if [ -z "$MOVIE_ID" ]; then
    echo "Usage: $0 <imdb_id>"
    exit 1
fi

API_KEY="bdf07e93"

RESPONSE=$(curl -s \
    "https://www.omdbapi.com/?i=$MOVIE_ID&apikey=$API_KEY")

TITLE=$(printf '%s\n' "$RESPONSE" | jq -r '.Title')

if [ -z "$TITLE" ]; then
    echo "Movie title not found"
    exit 1
fi

printf '%s\n' "$TITLE"
