start:
	@docker-compose down
	@printf "\033[1;34m === docker compose down ==== \033[0m"
	@docker-compose up -d
	@printf "\033[1;34m === docker compose start creation containes ==== \033[0m"
	@symfony server:start -d
	@printf "\033[1;34m === Server symfony is starting ==== \033[0m"
	@symfony open:local
	@printf "\033[1;34m === browser opening ==== \033[0m"
	@symfony console doctrine:database:create --if-not-exists -n
	@symfony console make:migration -n
	@symfony console doctrine:migrations:migrate -n
	@printf "\033[1;34m === doctrine migrations migrate ==== \033[0m"
	@symfony console doctrine:fixture:load -n
	printf "\033[1;34m === ajout des datas ds database fixture ==== \033[0m"
	printf "   "
	@printf "\033[42m                                     \033[0m"
	@printf "\033[1;30m\033[42m The Application MPS is running successfully\033[0m"
	@printf "\033[42m                                     \033[0m"



.PHONY: start


exp:
	@echo $^
	# @printf "\033[42m                                     \033[0m"
	# @printf "\033[1;30m\033[42m The Application MPS is running successfully\033[0m"
	# @printf "\033[42m                                     \033[0m"

.PHONY: exp

process: fichier*.txt
	@echo $^    "# $^ est une variable contenant la liste des dépendances de la # cible actuelle."
	@echo $@    "# $@ est le nom de la cible actuelle. En cas de cibles"
	@echo $<    "# $< contient la première dépendance."
	@echo $?    "# $? contient la liste des dépendances qui ne sont pas à jour."
	@echo $+    "# $+ contient la liste des dépendances avec d'éventuels # duplicatas, contrairement à $^."
	@echo $|    "# $| contient la liste des cibles ayant préséance sur la cible    # actuelle."

.PHONY: process

