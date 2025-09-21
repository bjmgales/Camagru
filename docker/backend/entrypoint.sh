#!/bin/sh
set -e

cp /etc/msmtprc.template /etc/msmtprc

sed -i "s|__GMAIL_USER__|$(printf '%s' "$GMAIL_USER")|g" /etc/msmtprc
sed -i "s|__GMAIL_PASS__|$(printf '%s' "$GMAIL_PASS")|g" /etc/msmtprc

chown www-data:www-data /etc/msmtprc
chmod 600 /etc/msmtprc

exec apache2-foreground
