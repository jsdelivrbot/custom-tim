def vscloud_partner="vsct"
def vscloud_docker_repository_host="docker-${vscloud_partner}.pkg.cloud.socrate.vsct.fr"

def tenant_docker_repository_name="webana"
def tenant_integ_host=""
def tenant_prod_host="t-${tenant_docker_repository_name}"
def tenant_token="943796ecc60249d2b6e6ad8088d54846"

def app_version="${currentBuild.number}"
def app_project_name="automated-mocks"
def app_tag="1.0-b${app_version}"
def app_image_name="${vscloud_docker_repository_host}/${tenant_docker_repository_name}/${app_project_name}"
def app_full_image_name="${app_image_name}:${app_tag}"

def image

def apache_version="2.2.32"
def php_version="5.6.27"

node {
  // Mark the code checkout 'stage'....
   stage ('Checkout') {
       checkout scm
       // git credentialsId: 'jenkins-git', url: 'git@gitlab.socrate.vsct.fr:emarketing/automated-mocks.git'
       stash name: 'docker-compose', includes: 'docker-compose*.yml'
   }

    //stage ('Build archive') {
    //    sh "tar zcvf ${project_name}-app-${tag}.tar.gz * --exclude='*.tar.gz' "
    //}

   //Mark the code build 'stage'....
   stage ('Packaging application') {
       // Run the maven build
       echo "BUILD IMAGE"

        //image = docker.build("${app_full_image_name}", " --build-arg APACHE_VERSION=${apache_version} --build-arg PHP_VERSION=${php_version} .")
        sh "sed -i 's|\${APACHE_VERSION}|${apache_version}|g' Dockerfile \n" +
            "sed -i 's|\${PHP_VERSION}|${php_version}|g' Dockerfile"
        image = docker.build("${app_full_image_name}")

       echo "PUSH IMAGE TO REPOSITORY"
       vscloud.dockerPush("${app_full_image_name}")
       vscloud.dockerPublishBuildInfo()
   }
}

//stage('Deploy to integration') {
//    deploy("integ", "${tenant_integ_host}", "${app_tag}", "${app_project_name}", "${app_image_name}", "${tenant_docker_repository_name}")
//}

stage("Release ?") {
    // Promote image in production with form to enter login and password
	vscloud.promoteArtifact()
}

//stage("Delivery") {
//    node {
//	    unstash "pom"
//	    def descriptor = Artifactory.mavenDescriptor()
//        def snapshots = descriptor.hasSnapshots()
//        if (snapshots) {
//            descriptor.version = tag
//        }
//        vscloud.promoteArtifact()
//    }
//}

stage('Deploy to production') {
    deploy("prod", "${tenant_prod_host}", "${app_tag}", "${app_project_name}", "${app_image_name}", "${tenant_docker_repository_name}")
}

node {
    stage('Update aliases') {
        sh "curl \
            --request PUT \
            --header 'X-Consul-Token: ${tenant_token}' \
            --header 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' \
            --data '${app_tag}.${app_project_name}-web' \
            http://osconsulh1:8500/v1/kv/t-webana/swarm_cluster/haproxy/alias/automatization.wat.voyages-sncf.com?dc=horsprod"

        sh "curl \
            --request PUT \
            --header 'X-Consul-Token: ${tenant_token}' \
            --header 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' \
            --data '${app_tag}.${app_project_name}-web' \
            http://osconsulh1:8500/v1/kv/t-webana/swarm_cluster/haproxy/alias/automatization.wat.oui.sncf?dc=horsprod"
    }
}

def deploy(env, tenantHost, appTag, appProjectName, appImageName, tenantDockerRepositoryName) {
    waitUntil {
        try {
            hp = vscloud.tenant("${tenantHost}")
            hp.onServer(credentialId: 'user_ci') {
                unstash "docker-compose"
                sh "set +x; export APP_TAG=${appTag}; export APP_PROJECT_NAME=${appProjectName}; export APP_IMAGE_NAME=${appImageName}; \n" +
                    "[ \$(docker network ls -f name=^${tenantDockerRepositoryName}-network\$ -q) ] || docker network create -d overlay ${tenantDockerRepositoryName}-network \n" +
                    "[ -f docker-compose.${env}.yml ] && envFile=\"-f docker-compose.${env}.yml\" || envFile=\"\" \n" +
                    "docker-compose -f docker-compose.yml -f docker-compose.deploy.yml \$envFile -f docker-compose.stack.yml config | docker stack deploy --with-registry-auth -c - ${appProjectName} \n"

                timeout(time: 5, unit: 'MINUTES') {
                    sh "set +x; while docker stack services --format '{{.Name}}: {{.Replicas}}' ${appProjectName} | awk -F ' |/' '\$2 < \$3 { print \$1 \" KO\"}' | grep -q KO; do docker stack services ${appProjectName};sleep 10; done;docker stack services ${appProjectName}"
                }
            }
            true
        } catch (org.jenkinsci.plugins.workflow.steps.FlowInterruptedException err) {
            true
        } catch (error) {
            echo "${error}"
            false
        }
    }
}