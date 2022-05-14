#!/usr/bin/env bash

cp -R /tmp/.ssh/* /var/www/.ssh

OWNER_UID="$(stat -c '%u' /var/www/test-pb)"
OWNER_GID="$(stat -c '%g' /var/www/test-pb)"

chown -R "${OWNER_UID}:${OWNER_GID}" /var/www/.ssh

info () {
  printf "\033[0;36m===> \033[0;33m%s\033[0m\n" "$1"
}

info "/var/www/test-pb owner is: ${OWNER_UID}:${OWNER_GID}"

if [[ "${OWNER_UID}" != "0" ]] && [[ "${OWNER_UID}" != "$(id -u www-data)" ]]; then
  info "Changing www-data UID to ${OWNER_UID}"
  usermod -u "${OWNER_UID}" www-data
fi

if [[ "${OWNER_GID}" != "0" ]] && [[ "${OWNER_GID}" != "$(id -g www-data)" ]]; then
  info "Changing www-data GID to ${OWNER_GID}"
  groupmod -g "${OWNER_GID}" www-data > /dev/null 2>&1
fi

[[ $(stat -c '%u' "${COMPOSER_HOME}") != "${OWNER_UID}" ]] && chown -R "${OWNER_UID}:${OWNER_GID}" "${COMPOSER_HOME}"

if [[ "$(id -u)" = "0" ]] && [[ "${OWNER_UID}" != "0" ]]; then
  info "exec with gosu $@"
  exec gosu www-data:www-data docker-php-entrypoint "$@"
fi

info "exec without gosu $@"

exec docker-php-entrypoint "$@"