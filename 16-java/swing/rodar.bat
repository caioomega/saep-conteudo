@echo off
REM Compila e abre a janela Java desta pasta.
cd /d "%~dp0"
set JBIN=C:\Program Files\Android\Android Studio\jbr\bin
if exist "%JBIN%\javac.exe" (set JAVAC="%JBIN%\javac.exe" & set JAVA="%JBIN%\java.exe") else (set JAVAC=javac & set JAVA=java)
%JAVAC% -encoding UTF-8 *.java
if errorlevel 1 goto fim
%JAVA% TelaProdutos
:fim
pause
