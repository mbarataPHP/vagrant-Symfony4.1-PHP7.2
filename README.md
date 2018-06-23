# vagrant symfony-4.1 php-7.2
## Installation evironnement

### Windows
#### Télécharger


* [https://www.virtualbox.org/](https://www.virtualbox.org/)
* [https://rubyinstaller.org/downloads/](https://rubyinstaller.org/downloads/)(**WITH DEVKIT 2.4.4-1**)
* [https://www.vagrantup.com/downloads.html](https://www.vagrantup.com/downloads.html)



#### Installation

ouvrir le **CMD** en tant que *Administrateur*

installez le plugin

```
vagrant plugin install vagrant-vbguest
```

Création de la VM

```
vagrant up --debug
```

## Utilisation environnement

Pour démarrer la VM

```
vagrant up
```

Pour vous connectez à la VM

```
vagrant ssh -- -t 'bash /alias.sh'
```


## environnement

### commandes

| alias | Description |
| --- | --- |
| start-service | Commande qui permet de démarrer les service (php-fpm, mysql, ngnix) |
| composer | Composer est un outil de gestion des dépendances en PHP  |
| phpunit | Exécute les tests de PHP |


### initialiser le projet

```
cd /vagrant/web/
make
```

### mysql

| login | mot de passe |
| :---: | :---: |
| vagrant | vagrant  |