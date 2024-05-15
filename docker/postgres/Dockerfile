FROM alpine:latest

#Mise à jour et installation des packages nécessaires
RUN echo "http://dl-cdn.alpinelinux.org/alpine/edge/testing/" >> /etc/apk/repositories && \
    apk update && \
    apk add --no-cache \
        postgresql \
        postgresql-client \
        php81-pgsql \
        php81-pdo_pgsql \
        vim


#Création du répertoire de données PostgreSQL et initialisation
RUN mkdir -p /app && \
    chown -R postgres:postgres /app && \
    su postgres -c 'initdb -D /app' && \
    chmod -R 750 /app


#Configuration de PostgreSQL
RUN echo "host  all      all     0.0.0.0/0    trust" >> /app/pg_hba.conf && \
    echo "listen_addresses = '*'" >> /app/postgresql.conf


#Variables d'environnement pour PostgreSQL
ENV POSTGRES_USER=test
ENV POSTGRES_PASSWORD=test123
ENV POSTGRES_DB=db


#Création des répertoires nécessaires pour le socket PostgreSQL
RUN mkdir /run/postgresql && chown postgres:postgres /run/postgresql\
    && mkdir /var/pgsql_socket/ \
    && ln -s /private/tmp/.s.PGSQL.5432 /var/pgsql_socket/


#Copie des scripts SQL
COPY script.sql /script.sql

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]