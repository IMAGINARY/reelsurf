FROM richarvey/nginx-php-fpm:php5

RUN apk --update add openjdk7-jre bash imagemagick

RUN apk add curl ca-certificates openjdk7 \
    && apk add --no-cache java-cacerts \
    && rm /usr/lib/jvm/java-1.7-openjdk/jre/lib/security/cacerts \
    && ln -s /etc/ssl/certs/java/cacerts /usr/lib/jvm/java-1.7-openjdk/jre/lib/security/cacerts \
    && curl -L https://github.com/IMAGINARY/jsurf/archive/v0.3.0.tar.gz | tar xvz -C /tmp \
    && cd /tmp/jsurf-0.3.0/ \
    && ./gradlew distTar \
    && tar xf build/distributions/jsurf-0.3.0.tar \
    && cp -r jsurf-0.3.0/lib /usr/lib/jsurf \
    && cd / \
    && rm -r /tmp/jsurf-0.3.0 \
    && rm /usr/lib/jvm/java-1.7-openjdk/jre/lib/security/cacerts \
    && apk del curl ca-certificates openjdk7

ENV WEBROOT /var/www/html2
COPY createanim* /var/www/html2/
RUN ln -s /var/www/html2/createanimform.html /var/www/html2/index.html
RUN mkdir /var/www/html2/js \
    && cd /var/www/html2/js \
    && wget http://code.jquery.com/jquery-1.7.min.js \
    && wget https://cdn.rawgit.com/pisi/Reel/v1.3.0/jquery.reel-min.js
RUN mkdir /var/www/html2/pics && chmod 777 /var/www/html2/pics
