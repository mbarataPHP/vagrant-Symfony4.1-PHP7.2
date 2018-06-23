#!/usr/bin/env bash




#alias phpunit
if  grep -qF "phpunit" ~/.bashrc
then
    echo ''
else

    echo "alias phpunit='php /usr/local/bin/phpunit.phar'" >> ~/.bashrc

fi

#alias start-service
if  grep -qF "start-service" ~/.bashrc
then
    echo ''
else

    echo "alias start-service='/usr/local/bin/service.sh'" >> ~/.bashrc

fi

#alias composer
if  grep -qF "composer" ~/.bashrc
then
    echo ''
else
    echo "alias composer='/usr/local/bin/composer.phar'" >> ~/.bashrc

fi



echo -e '\e[38;5;82m'
echo '***************************************************************************************'
echo '* start-service * Commande qui permet de démarrer les service (php-fpm, mysql, ngnix) *'
echo '***************************************************************************************'
echo '* composer      * Composer est un outil de gestion des dépendances en PHP             *'
echo '***************************************************************************************'
echo '* phpunit       * Exécute les tests de PHP                                            *'
echo '***************************************************************************************'
echo -e '\e[39m'

bash /usr/local/bin/service.sh

exec bash