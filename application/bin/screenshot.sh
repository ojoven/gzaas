#!/bin/bash

# $1 -> urlKey
# $2 -> Base URL
# $3 -> Path to Application
# $4 -> Width Screenshot
# $5 -> Height Screenshot

# Retrieve args
urlKey=$1
baseUrl=$2
basePath=$3
width=$4
height=$5

# Let's create the static screenshot
pathScreenshotJs=$basePath"/bin/screenshot.js"
suffixImage="?screenshot=image"
gzaasUrl=$baseUrl"/"$urlKey$suffixImage
extension="jpg"
pathImage=$basePath"/tmp/"$urlKey"."$extension

phantomjs $pathScreenshotJs $urlKey $gzaasUrl $pathImage $width $height

# Let's call the script that will upload the image to Amazon S3
pathUpload=$basePath"/bin/screenshot.php"

php $pathUpload $urlKey
