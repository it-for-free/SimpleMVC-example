#Задаем подкоманды для изменения цвета
export red=`tput setaf 1`
export green=`tput setaf 2`
export yellow=`tput setaf 3`
export blue=`tput setaf 4`
export magenta=`tput setaf 5`
export cyan=`tput setaf 6`
export white=`tput setaf 7`
export reset=`tput sgr0`

PROJECT_NAME = smvc-primer

APP_CONTANER_COMMAND_PREF_DB = @docker exec -it $(PROJECT_NAME)_db

LOCAL_APP_URL_MESSAGE = @echo  "SMVC в деле ;)"
COMPOSE_DEV = docker compose -f ./docker/docker-compose.yml  --project-name $(PROJECT_NAME)

about:
	@echo "${cyan}Привет!)${reset} Это мэйкфайл для удобной работы с командами ${cyan};)${reset}  \
     \n Выполняйте нужные действия с помощью ${yellow}make имякоманды${reset}, доступные команды: \
     \n ${green}migrate${reset} - применит миграции \
     \n ${green}docker.start.all${reset} - Запустит все контейнеры приложения (соберет образы, если их нет) \
     \n ${green}docker.stop.all${reset} - Остановит все контейнеры приложения \
     \n ${green}docker.restart.all${reset} - Остановит все контейнеры приложения и запустит их заново \
	 \n ${green}docker.rebuild.all${reset} - Остановит все контейнеры приложения, пересоберет их запустит их заново \
	"

# DOCKER---------------------------------------
sh.db:
	$(APP_CONTANER_COMMAND_PREF_DB) sh

docker.start.all:
	$(COMPOSE_DEV)  up -d
	$(LOCAL_APP_URL_MESSAGE)

docker.stop.all:
	$(COMPOSE_DEV)  stop   

docker.rebuild.all: docker.stop.all
	$(COMPOSE_DEV)  up -d --build
	$(LOCAL_APP_URL_MESSAGE)

docker.restart.all: docker.stop.all docker.start.all

docker.remove.db:
	docker rm $(PROJECT_NAME)_db

docker.reset.all: docker.stop.all docker.remove.db docker.rebuild.all

docker.php.sh:
	$(APP_CONTANER_COMMAND_PREF_PHP) sh

#APPLICATION--------------------------------------
composer.install:
	@echo  "Устанавливаем ${yellow}зависимости${reset}..."
	$(APP_CONTANER_COMMAND_PREF_PHP) composer install




