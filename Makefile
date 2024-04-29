pip-install:
	@echo "Installing python packages..."
	pip install mysql-connector-python

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
	if [ ! -d "/opt/lampp" ]; then \
		make pip-install; \
        make install; \
	fi
	sudo cp index.php /opt/lampp/htdocs
	sudo mkdir -p /opt/lampp/htdocs/php
	sudo cp php/* /opt/lampp/htdocs/php
	sudo /opt/lampp/lampp start
	python3 xampp-script.py
#	python3 mongodb-script.py
# mongodb
	
start:
	sudo /opt/lampp/lampp start