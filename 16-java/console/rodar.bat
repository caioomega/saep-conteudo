@echo off
REM Compila e roda o programa Java desta pasta.
REM Usa o Java que vem junto com o Android Studio (no seu PC).
cd /d "%~dp0"
chcp 65001 >nul
set JBIN=C:\Program Files\Android\Android Studio\jbr\bin
if exist "%JBIN%\javac.exe" (set JAVAC="%JBIN%\javac.exe" & set JAVA="%JBIN%\java.exe") else (set JAVAC=javac & set JAVA=java)
%JAVAC% -encoding UTF-8 *.java
if errorlevel 1 goto fim
%JAVA% -Dstdout.encoding=UTF-8 -Dstdin.encoding=UTF-8 SistemaEstoque
:fim
pause
