#!/usr/bin/env bash

set -e
set -o pipefail

function usage(){
  echo "Usage: $0 [--deploy]"
  exit 2;
}

function exit_script() {
    echo "$0 exit: $?" && exit $?
}

## Process cli params
for p in "$@";
do
    case $p in
    --deploy)
        TASK="deploy"
    ;;
    *)
        echo "Invalid parameter ${p}"
        usage
    esac
done

# Install composer if it's not already installed
echo "### Composer ###"
if [ ! -f composer.phar ] ; then
    echo "### Install Composer ###"
    curl -sS https://getcomposer.org/installer | php || exit_script
fi

# Tasks to complete if deploying
if [ "${TASK}" = "deploy" ] ; then
    echo "### Composer Install Deployment ###"
    time php composer.phar install --no-dev || exit_script
    exit
fi

echo "### Composer Install Build ###"
time php composer.phar install || exit_script

echo "### Codeception ###"
time bin/codecept run unit --coverage

echo "### PHP Codesniffer ###"
time bin/phpcs --extensions=php --standard=PSR2 --ignore=*/vendor/*,*/Tests/_support/_generated ./ || exit_script

echo "### PHP Mess Detector ###"
time bin/phpmd src text phpmd-ruleset.xml --strict --exclude vendor,Tests/_support/_generated --suffixes php || exit_script

echo "build.sh exit: $?"