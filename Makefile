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