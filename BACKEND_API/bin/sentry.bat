@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/sentry/sentry/bin/sentry
php "%BIN_TARGET%" %*
