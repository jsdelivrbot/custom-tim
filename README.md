TIM
========================

Tag Incident Manager : Outil de désactivation des tags du framework VSCA sur toutes les zones du site oui.sncf

Requirements
------------

  * PHP 7.2.3 or higher;
  * PDO-Mysql PHP extension enabled;
  * Mysqli
  * Autres dépendences symfony .

Installation
------------
Cette documentation a été rédigée avec une syntaxe pour Cygwin, en admettant que la commande $(cygpath -w $(pwd)) fonctionne correctement. Pour les utilisateurs Windows/Linux, vous devrez ré-adapter cette syntaxe en fonction de votre terminal :


    Linux : $(pwd)
    PowerShell: ${PWD}
    Command (cmd.exe): %cd%
    Cygwin: $(cygpath -w $(pwd))

Executer ces commandes pour installer le projet:

```bash
$ docker run --rm -v $(cygpath -w $(pwd)):/app docker-vsct.pkg.cloud.socrate.vsct.fr/webana/php-composer:7.2.3-1.6.3 install
$ docker run --rm -v $(cygpath -w $(pwd)):/opt/app docker-vsct.pkg.cloud.socrate.vsct.fr/webana/node-yarn:7.1.0-0.23.4 run dev

```

Lancement
-----

```bash
$ docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d
```

Url
----
    http://dev.tim.wat.vsct.fr/public/index.php/
    
Testes
-----

Execute this command to run tests:

```bash
$ 
```

# custom-tim
