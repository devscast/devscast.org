# Devscast Community Platform

[![License: CC BY 4.0](https://img.shields.io/badge/License-CC_BY_4.0-lightgrey.svg)](https://creativecommons.org/licenses/by/4.0/) [![Lint](https://github.com/devscast/devscast.org/actions/workflows/lint.yaml/badge.svg)](https://github.com/devscast/devscast.org/actions/workflows/lint.yaml) [![Tests](https://github.com/devscast/devscast.org/actions/workflows/test.yaml/badge.svg)](https://github.com/devscast/devscast.org/actions/workflows/test.yaml)

La plateforme communautaire Devscast est destinée à ceux qui veulent avoir un impact sur la communauté en créant du contenu autour de leurs passions, en partageant des connaissances, mais aussi en apprenant.

Le but de la plateforme sera de promouvoir les profils de tous les développeurs de la communauté, mais aussi de centraliser les ressources d'apprentissage françaises, les opportunités de travail, etc...

Les utilisateurs peuvent publier du contenu afin d'aider les autres, mais aussi pour apprendre et augmenter leur visibilité.


## Présentation et introduction technique au projet

<p align="center">
  <a href="https://www.youtube.com/watch?v=v70D9UuEx8Y">
      <img src="https://img.youtube.com/vi/v70D9UuEx8Y/0.jpg" alt="introduction au projet" />
  </a>
</p>

### Conditions requises

- [Docker](https://www.docker.com/) : Un conteneur est une unité logicielle standard qui regroupe le code et toutes ses dépendances, de sorte que l'application s'exécute rapidement et de manière fiable d'un environnement informatique à un autre.

## Installation et fonctionnement

```bash
git clone https://github.com/devscast/devscast.org devscast.org
cd devscast.org
```
après avoir cloné le projet, vous devez installer les dépendances requises en exécutant la commande suivante dans le dossier du projet

pour éviter les problèmes de permission avec docker, assurez-vous que les deux variables d'environnement suivantes sont définies sur votre machine
```bash
# dans .bashrc ou .zshrc 
export USER_ID=$(id -u)
export GROUP_ID=$(id -g)
```

you can also add an alias to facilitate command execution in the container 

```bash
# dans .bashrc ou .zshrc
alias dr="USER_ID=$(id -u) GROUP_ID=$(id -g) docker-compose run --rm"

# exemples
# dr [service] command

dr php bin/console c:c
dr node yarn install
```

en suite
```bash
make install
```

finalement vous pouvez lancer l'application avec 👇🏾.
```bash
make dev
```

## Comment contribuer

Les contributions sont encouragées et peuvent être soumises en "fork" de ce projet et en soumettant une demande de modification (pull request). Comme ce projet n'en est qu'à ses débuts, si votre modification est substantielle, veuillez d'abord soulever un problème (Issue) pour en discuter.

Nous avons également besoin de personnes pour tester les pull-requests. Jetez donc un coup d'œil sur [les problèmes ouverts](https://github.com/devscast/devscast.org/issues) et aidez-nous si vous le pouvez.

**pour plus d'info, lisez le [CONTRIBUTING.md](https://github.com/devscast/devscast.org/blob/master/CONTRIBUTING.md "CONTRIBUTING.md")**


### Code style et tests
Si vous constatez que l'une de vos pull reviews ne passe pas la vérification du serveur CI en raison d'un conflit de style de code, vous pouvez facilement le corriger en exécutant :

```bash
make lint 
make test
```

### contributors

<a href="https://github.com/devscast/devscast.org/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=devscast/devscast.org"/>
</a>

## Suivez nous

Nous sommes sur les médias sociaux:

- [@DevscastTech](https://twitter.com/devscasttech) sur Twitter. Vous devriez le suivre.
- [Devscast](https://www.linkedin.com/company/devscast/) sur LinkedIn 
- [@devscast.tech](https://www.instagram.com/devscast.tech/) sur Instagram.
- [devscast.tech](https://web.facebook.com/devscast.tech/) sur Facebook.
- [Devscast](https://www.youtube.com/channel/UCsvWpowwYtjfgS1BOcrX0fw) sur Youtube.
- [devscast.tech](https://www.tiktok.com/@devscast.tech) sur Tiktok.
