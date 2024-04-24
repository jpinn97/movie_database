ENV_NAME := movie_env
REQUIREMENTS_FILE := requirements.txt

conda-install:
    @echo "Creating conda environment named $(ENV_NAME)..."
    conda env create -n $(ENV_NAME)
    conda activate $(ENV_NAME)
    conda config --add channels conda-forge
    conda config --set channel_priority strict
    conda install -c conda-forge --file $(REQUIREMENTS_FILE)

conda-clean:
    @echo "Removing conda environment $(ENV_NAME)..."
    conda env remove -n $(ENV_NAME) -y