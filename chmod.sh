#!/bin/bash

# Ubah izin semua file biasa menjadi 644
find /home/sia/public_html -type f -exec chmod 644 {} \;

# Ubah izin semua direktori menjadi 755
find /home/sia/public_html -type d -exec chmod 755 {} \;