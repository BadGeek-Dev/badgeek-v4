FIG=docker-compose
RUN=$(FIG) run --rm
EXEC=$(FIG) exec

.PHONY: start stop reset install build up vendor

start: build up

install: start vendor database-import db-migrate

stop:
	$(FIG) stop && $(FIG) rm -f

reset: stop start

build:
	$(FIG) build

up:
	$(FIG) up -d

vendor:
	$(RUN) -w /badgeek/application php composer install
	$(RUN) -w /badgeek/assets php yarn install

database-import:
	$(RUN) mysql mysql -h mysql -u badgeek -pbadgeek badgeek < assets/dump-initial.sql

db-migrate:
	$(RUN) -w /badgeek php php index.php migrate

podcast_sync:
	$(RUN) -w /badgeek php php index.php task podcast_sync