pip-install:
	@echo "Installing python packages..."
	pip install -r requirements.txt

pip-clean:
	@echo "Removing python packages..."
	pip freeze | xargs pip uninstall -y

install:
	wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/8.2.12/xampp-linux-x64-8.2.12-0-installer.run
	chmod +x xampp-linux-x64-8.2.12-0-installer.run
	sudo ./xampp-linux-x64-8.2.12-0-installer.run
	sudo apt-get install -y php
	sudo apt-get install -y php-dev
	sudo apt-get install -y php-pear
	sudo pecl update-channels
	sudo yes '' | sudo /opt/lampp/bin/pecl install mongodb
	sudo apt-get install -y mongodb-org
	sudo apt-get install -y composer
	echo "extension=mongodb.so" | sudo tee -a /opt/lampp/etc/php.ini
	echo "extension=mongodb.so" | sudo tee -a /etc/php/8.1/cli/php.ini
	cd /opt/lampp/htdocs && sudo composer require mongodb/mongodb --ignore-platform-reqs	

full-setup:
# xampp/lamp
	if [ ! -d "/opt/lampp" ]; then \
		make pip-install; \
        make install; \
	fi
	sudo cp index.php /opt/lampp/htdocs
	sudo mkdir -p /opt/lampp/htdocs/php
	sudo cp php/* /opt/lampp/htdocs/php
	
start:
	sudo /opt/lampp/lampp restart
	sudo systemctl start mongod
	sleep 1
	python3 xampp-script.py
	python3 mongodb-script.py