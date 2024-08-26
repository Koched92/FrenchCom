FIG=docker compose

HAS_DOCKER:=$(shell command -v $(FIG) 2> /dev/null)

ifdef HAS_DOCKER
	EXEC=$(FIG) exec app
	EXEC_DB=$(FIG) exec mysql_db
# Sinon, on exécute les commandes sur la machine locale
else
	EXEC=
	EXEC_DB=
endif
CONSOLE=php bin/console
.DEFAULT_GOAL := help
.PHONY: start start.daemon stop restart update upgarde entity cc migration migrate migrations.list db.recreate db.drop db.create check upgrade help

# =========================== #
# Manipulation des conteneurs #
# =========================== #
up: ## Démarrage des conteneurs et affiche les logs en temps réel
	$(FIG) up -d
stop: ## Arrête les conteneurs
	$(FIG) down
restart: stop up ## Arrête et redémarre les conteneurs

# ===================== #
# Mise à jour du projet #
# ===================== #
update: ## Met à jour le projet avec les informations de composer.lock (ne les met pas à jour)
	$(EXEC) composer install
upgrade: ## Met à jour le projet avec les informations de composer.json (met à jour le composer.lock)
	$(EXEC) composer update

# ================================== #
# Manipulation de la base de données #
# ================================== #
entity: ## Crée ou modifie une entité
	$(EXEC) $(CONSOLE) make:entity
cc: ## Vide le cache du projet
	$(EXEC) $(CONSOLE) cache:clear
migration: ## Génère une migration avec les changements des entités
	$(EXEC) $(CONSOLE) make:migration
migrate: ## Exécute les migrations
	$(EXEC) $(CONSOLE) doctrine:migrations:migrate -n
migrations.list: ## Liste les migrations
	$(EXEC) $(CONSOLE) doctrine:migrations:list
db.recreate: db.drop db.create migrate fixtures  ## Commande (d'urgence) pour recréer la BdD depuis 0
db.drop:
	$(EXEC) $(CONSOLE) doctrine:database:drop -f
db.create:
	$(EXEC) $(CONSOLE) doctrine:database:create
fixtures: ## Charger les fixtures (Attention, vide la BdD !)
	$(EXEC) $(CONSOLE) doctrine:fixtures:load -n

# ========================= #
# Génération de formulaires #
# ========================= #
form: ## Crée un formulaire Symfony
	$(EXEC) $(CONSOLE) make:form
admin.crud: ## Crée un CRUD pour l'admin (EasyAdmin)
	$(EXEC) $(CONSOLE) make:admin:crud

# ================#
# Qualité de code #
# ================#
check: ## Vérification de la qualité et de la cohérence du code
	vendor/bin/grumphp run
csfix: ## Correction (automatique) de la qualité du code
	vendor/bin/php-cs-fixer fix

# ============= #
# npm command   #
# ============= #
install: ## installer les dependances webpack
	$(EXEC) npm install
watch: ## lancer le serveur de developpement
	$(EXEC) npm run watch

# ============= #
# Déploiement   #
# ============= #
deploy:
	$(EXEC) vendor/bin/dep deploy

# ============= #
# Documentation #
# ============= #
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-9s\033[0m %s\n", $$1, $$2}'

