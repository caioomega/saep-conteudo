@echo off
REM Dois cliques aqui pra ligar o servidor Node desta pasta.
REM Usa o Node portátil que está no seu PC. Pra parar: feche esta janela.
cd /d "%~dp0"
set NODE=%LOCALAPPDATA%\Programs\node-portable\node.exe
if not exist "%NODE%" set NODE=node
start "" http://localhost:3000
"%NODE%" servidor.js
pause
