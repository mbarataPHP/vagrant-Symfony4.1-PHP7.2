#!/usr/bin/env bash

if [ -e public/bundle.js ]
then
     rm public/bundle.js
fi
yarn webpack
