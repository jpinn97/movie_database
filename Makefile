ENV_NAME := movie_env
REQUIREMENTS_FILE := requirements.txt

conda-install:
	@echo "Creating conda environment named $(ENV_NAME)..."
	conda create -n $(ENV_NAME) --yes
	conda config --env --add channels conda-forge
	conda config --env --set channel_priority strict
	conda install -n $(ENV_NAME) --file $(REQUIREMENTS_FILE) --yes

conda-clean:
	@echo "Removing conda environment $(ENV_NAME)..."
	conda env remove -n $(ENV_NAME) --yes

pip-install:
	@echo "Installing python packages..."
	pip install -r $(REQUIREMENTS_FILE)

pip-clean:
	@echo "Removing python packages..."
	pip freeze | xargs pip uninstall -y

install:
	wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/8.2.12/xampp-linux-x64-8.2.12-0-installer.run
	chmod +x xampp-linux-x64-8.2.12-0-installer.run
	sudo ./xampp-linux-x64-8.2.12-0-installer.run
	sudo apt-get install -y mongodb-org

full-setup:
# xampp/lamp
	@if [ ! -d "/opt/lampp" ]; then \
        make install; \
	fi
	python3 xampp-script.py
	sudo cp index.php /opt/lampp/htdocs
	sudo mkdir -p /opt/lampp/htdocs/php
	sudo cp php/* /opt/lampp/htdocs/php
# mongodb
	python3 mongodb-script.py
