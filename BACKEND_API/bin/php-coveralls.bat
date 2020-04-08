@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/satooshi/php-coveralls/bin/php-coveralls
php "%BIN_TARGET%" %*
