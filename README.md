Site: enigma-dev.org
================================================================================

This is the code to the remainder of the ENIGMA website; most of it is five
years old. It's probably going to be completely recoded, one day, long from
now, but I figure we may as well commit it in the meantime.

If you see anything that might be considered exploitable, please let us know.

Bootstrapping the ENIGMA server, V1
================================================================================

## Main site

The site's operational files are all under `/var/www/html`, but there are a lot
of other configuration steps to prepare Apache to serve this web content.

### HTTPD Configuration

Most importantly, `httpd.conf` must be modified to list virtual host
specifications for each website hosted on the server (eg, `enigma-dev.org`,
`lateralgm.org`, ...). After the first migration, these have all been placed
at the bottom of `httpd.conf`, instead of scattering them throughout a separate
`vhosts` folder. This should minimize effort to port over our configuration in
the future.

It is important to note that each of these vhosts declares a `<directory>`
location, and then allows `.htaccess` to override all filetypes within that
directory. This is important for the Wiki, the main site pages, and the error
document handlers to function properly.

Also, I ended up having to make some iptables calls myself to open the
HTTP/HTTPS ports. For whatever reason, that wasn't handled automatically,
and firewalld doesn't seem to be installed/configured....

## EnigmaBot

Like the rest of the site, the source code for EnigmaBot is up on GitHub.
EnigmaBot depends on Python 2.6-2.7, which are the default as of CentOS 7.
EnigmaBot also depends on ASpell. Python bindings for ASpell are up on GitHub.
The bot, and all source code needed to build it, is in Josh's home folder.

## Other miscellaneous config

### Secure Shell

Each home folder contains `authorized_keys` in its `.ssh` directory.
For security, it is important that password authentication be disabled,
and also ssh as root.

### MySQL

This is all managed by MariaDB... it seems pretty flaky. I imagine we'll have
more problems with it going forward. My only point of advice is to skip on the
PhpMyAdmin and do the database import/export manually using the `mysql` CLI.

### SSL

As long as you copy the three certificate files from `/etc/pki/tls/certs`
referenced in `httpd.conf`, everything should work. One of those is the
server's private key. One of them is a signed certificate obtained from
Dynadot by issuing them a Certificate Signing Request (the `.csr` file in
that directory) and paying them monies. The final one is a vanilla AlphaSSL
certificate obtained using Google and picking the right file for a date.
Failure to include that certificate will lead to passive-agressive errors
in, eg, Python, when attempting to verify the certificate.

### welcometoenigma

The code for the MOTD is also in Josh's home folder. It should probably be
committed at some point, but doesn't really belong anywhere and isn't exactly
important.

Why is all this stuff in Josh's home folder? Josh is afraid to put it anywhere
else.
