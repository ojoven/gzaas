#!/bin/bash

# $1 -> urlKey
# $2 -> Absolute URL to Gzaas
# $3 -> Path to Image being generated
# $4 -> Path to PhantomJs Bins JS file
# $5 -> Width Screenshot
# $6 -> Height Screenshot

phantomjs $4 $1 $2 $3 $5 $6
