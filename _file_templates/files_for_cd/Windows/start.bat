@echo off
cd %0\..
cd /d %0\.. 
start chrome-win32\chrome.exe --app="%CD%\datafiles\index.html" --allow-file-access-from-files
cls