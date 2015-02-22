@echo off
title Starving 2 Resource Pack Downloader
echo Adding files...
git add .
echo Creating commit...
set /p commitMsg= Type commit message: 
git commit -am %commitMsg%
echo Pushing...
git push
echo Done!