@echo off

SET mypath="%~dp0"
echo %mypath:~0,-1%

SET NEWLINE=^& echo.

FIND /C /I "dev.stats.coach" %WINDIR%\system32\drivers\etc\hosts
IF %ERRORLEVEL% NEQ 0 ECHO %NEWLINE%^127.0.0.1 dev.stats.coach>>%WINDIR%\System32\drivers\etc\hosts

php -S dev.stats.coach:80 index.php