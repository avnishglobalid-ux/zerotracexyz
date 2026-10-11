FROM php:8.4-cli

WORKDIR /app

COPY index.php data.json ./

EXPOSE 10000

CMD ["sh", "-c", "php -d opcache.enable=0 -d opcache.enable_cli=0 -d opcache.lockfile_path=/tmp -S 0.0.0.0:${PORT:-10000} -t /app"]