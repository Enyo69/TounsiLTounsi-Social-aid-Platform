@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/heroku/heroku-buildpack-php/bin/heroku-hhvm-apache2
bash "%BIN_TARGET%" %*
