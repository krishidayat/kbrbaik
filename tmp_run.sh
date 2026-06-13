#!/bin/bash
# Fix CORS for HTTPS
sed -i 's/throw new Zend_Controller_Action_Exception/\/\/throw new Zend_Controller_Action_Exception/' /usr/share/airtime/php/airtime_mvc/application/common/CORSHelper.php 2>/dev/null
# Increase PHP upload limits
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 150M/' /etc/php/7.0/apache2/php.ini 2>/dev/null
sed -i 's/post_max_size = .*/post_max_size = 160M/' /etc/php/7.0/apache2/php.ini 2>/dev/null
sed -i 's/max_execution_time = .*/max_execution_time = 300/' /etc/php/7.0/apache2/php.ini 2>/dev/null
# Fix TCP proxy port
sed -i 's/libretime-icecast:35112/libretime-icecast:8000/' /etc/supervisor/conf.d/supervisord.conf 2>/dev/null
# Fix hosts entry for analyzer API access
GATEWAY=172.19.0.1
sed -i "s/^127.0.0.1.*$/$GATEWAY airtime libretime radio.kbrbaik.live/" /etc/hosts 2>/dev/null || true
