#!/bin/bash
#* initialize.sh:

echo 0 > daynum.dat
echo 0 > token.dat

chmod +w daynum.dat
chmod +w token.dat

[ -d data ] || mkdir data
echo order deny,allow > data/.htaccess
echo deny from all >> data/.htaccess