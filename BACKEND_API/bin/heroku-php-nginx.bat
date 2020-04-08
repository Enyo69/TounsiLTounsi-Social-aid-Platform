@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/heroku/heroku-buildpack-php/bin/heroku-php-nginx
bash "%BIN_TARGET%" %*
