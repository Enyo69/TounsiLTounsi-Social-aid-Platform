@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/sebastianfeldmann/captainhook/captainhook
php "%BIN_TARGET%" %*
