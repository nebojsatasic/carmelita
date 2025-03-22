pipeline {
    agent any

    environment {
        GITHUB_REPO = 'https://github.com/nebojsatasic/carmelita.git'
        DEPLOY_DIR = '/var/www/carmelita'
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    // Clone or pull from GitHub repository
                    git url: "${GITHUB_REPO}", credentialsId: '', branch: 'main'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    // Ensure the directory is owned by Apache to allow write access
                    sh 'sudo chown -R www-data:www-data ${DEPLOY_DIR}'
                    
                    // Copy files from the workspace to the web directory, excluding .git and .gitignore
                    sh 'sudo rsync -av --delete --exclude=".git" --exclude=".gitignore" ${WORKSPACE}/ ${DEPLOY_DIR}/public_html/'
                    // Copy files containing sensitive data from the secure location to ensure that sensitive information is not exposed in the Git repository
                    sh 'sudo cp ${DEPLOY_DIR}/data/init.php ${DEPLOY_DIR}/public_html/app/core/init.php'
                    sh 'sudo cp ${DEPLOY_DIR}/data/PaymentController.php ${DEPLOY_DIR}/public_html/app/controllers/PaymentController.php'

                    // Change ownership after copying the files to ensure Apache can access them
                    sh 'sudo chown -R www-data:www-data ${DEPLOY_DIR}'
                }
            }
        }
    }

    post {
        always {
            echo 'Deployment complete.'
        }
    }
}
