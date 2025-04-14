@echo off
setlocal

REM Recupera o caminho do projeto e do diretorio publico
set "Directory_Path=%~dp0"
set "Directory_Path=%Directory_Path:~0,-1%"
set "Public_Directory=%Directory_Path%\public"

REM Abre o VS Code no diretório do projeto
start "" code "%Directory_Path%"
timeout /t 2 >nul

REM Inicia o servidor e abre o site no navegador (Opera)
start "" opera "http://localhost:2020"
timeout /t 2 >nul
cd /d "%Public_Directory%"
start /B php -S localhost:2020

exit
