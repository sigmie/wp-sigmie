#!/bin/bash

# Define your themes
themes=(
"aura-light-amber"
"aura-light-green"
"aura-light-noir"
"aura-light-teal"
"aura-light-blue"
"aura-light-indigo"
"aura-light-pink"
"aura-light-cyan"
"aura-light-lime"
"aura-light-purple"
)


# Clear assets directory 
echo 'Clearing public/assets directory'
rm -rf public/assets/*

# Loop through each theme and set the SIGMIE_THEME environment variable
for theme in "${themes[@]}"; do
  echo "Building theme: $theme"
  SIGMIE_THEME=$theme npm run build
done
