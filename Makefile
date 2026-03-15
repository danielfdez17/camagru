COMPOSE := docker compose

.PHONY: help build up dev down stop restart logs ps clean shell-php shell-nginx shell-db db-cli

# ? ❓ Displays this help message
help:
	@awk '\
		BEGIN { blue = "\033[0;34m"; green = "\033[0;32m"; reset = "\033[0m"; yellow = "\033[0;33m"; print yellow "Usage: make [target]"; print "Targets:" } \
		/^# \?/ { desc = substr($$0, 5); next } \
		/^$$/ { desc = ""; next } \
		/^[a-zA-Z0-9][a-zA-Z0-9_.-]*:/ { \
			target = $$1; \
			sub(/:.*/, "", target); \
			if (target !~ /^\./) \
				printf "  " blue "%-12s" reset green "%s" reset "\n", target, desc; \
			desc = ""; \
		}' $(firstword $(MAKEFILE_LIST))

# ? 🏗️  Builds the Docker images
build:
	$(COMPOSE) build

# ? 🚀  Starts the containers in detached mode with build
up:
	$(COMPOSE) up -d --build

# ? 🚀  Starts the containers in foreground with build
dev:
	$(COMPOSE) up --build

# ? 🛑  Stops and removes the containers, networks, and volumes
down:
	$(COMPOSE) down

# ? 🛑  Stops the containers without removing them
stop:
	$(COMPOSE) stop

# ? 🔄  Restarts the containers with build
restart:
	$(COMPOSE) down
	$(COMPOSE) up -d --build

# ? 🔄  Restarts the containers
re: fclean up

# ? 📜  Follows the logs of all containers
logs:
	$(COMPOSE) logs -f

# ? 📋  Lists the running containers
ps:
	$(COMPOSE) ps

# ? 🖼️  Lists the images used by the services
images:
	$(COMPOSE) images

# ? 📊  Shows the status of containers and images
status: images ps

# ? 🧹  Stops and removes containers, networks, volumes, and images
clean:
	$(COMPOSE) down --remove-orphans

# ? 🧹  Stops and removes containers, networks, images, and orphans (keeps volumes)
fclean:
	$(COMPOSE) down --rmi all --remove-orphans

# ? 🐚  Opens a shell in the PHP container
shell-php:
	$(COMPOSE) exec php sh

# ? 🐚  Opens a shell in the Nginx container
shell-nginx:
	$(COMPOSE) exec nginx sh

# ? 🐚  Opens a shell in the PostgreSQL container
shell-db:
	$(COMPOSE) exec db sh

# ? 🐚  Opens a psql client connected to the PostgreSQL container
db-cli:
	$(COMPOSE) exec db psql -U $${DB_USER:-user} -d $${DB_NAME:-bookdb}

