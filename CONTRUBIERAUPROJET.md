# DOCUMENTATION

## Comment contribuer au projet

### Faire une une duplication du depot ou fork

1. Aller dans le coin superieur de la page et cliquez sur fork pour dupliquer

2. Sous « Propriétaire ou owner », sélectionnez le menu déroulant et cliquez sur un propriétaire pour le dépôt dupliqué.

3. Par défaut, les duplications ont le même nom que leurs référentiels en amont. Si vous le souhaitez, pour mieux distinguer votre duplication, dans le champ « Nom du dépôt », tapez un nom.

4. Dans le champ « Description », vous pouvez taper la description de votre duplication.

5. Si vous le souhaitez, sélectionnez Copier la branche PAR DÉFAUT uniquement.

6. Cliquez sur Créer une duplication ( create fork)


### Cloner le depot sur votre machine

Si vous avez correctement dupliqué (fork) le dépôt TodoList, il existe uniquement sur GitHub. Pour pouvoir travailler sur le projet, vous avez besoin de le cloner sur votre ordinateur.

Vous pouvez cloner votre duplication (fork) avec la ligne de commande, GitHub CLI ou GitHub Desktop.

1. Sur GitHub, accédez à votre duplication (fork) du dépôt TodoList.

2. Au-dessus de la liste des fichiers, cliquez sur  Code.

3. Copiez l’URL du dépôt.

    - Pour cloner le dépôt avec le protocole HTTPS, sous « HTTPS », cliquez sur  HTTPS et copier le lien.

    - Pour cloner le dépôt avec une clé SSH, en incluant un certificat émis par l’autorité de certification SSH de votre organisation, cliquez sur SSH et copier le ien.

    - Pour cloner un dépôt avec GitHub CLI, cliquez sur GitHub CLI et copier le ien.

    - Ouvrez Git Bash. 

    - Remplacez le répertoire de travail actuel par l’emplacement où vous voulez mettre le répertoire cloné.

4. Tapez git clone, puis collez l’URL que vous avez copiée précédemment. Voici ce à quoi cela ressemble, avec votre nom d’utilisateur(YOUR-USERNAME) GitHub  :

Commande:
```
$ git clone https://github.com/YOUR-USERNAME/TodoList 

```
5. Appuyez sur Entrée. Votre clone local va être créé.

### Création d’une branche sur laquelle travailler

Avant d’apporter des modifications au projet, vous devez créer une nouvelle branche et l’extraire. En conservant les modifications apportées à votre branche, vous suivez GitHub Flow et vous garantissez la facilité à contribuer au projet dans le futur . Pour plus d’informations, consultez « GitHub flow ».

Commande: 
```
git branch BRANCH-NAME
git checkout BRANCH-NAME

```
###  Apporter et pousser (push) des modifications

Poursuivez en apportant quelques modifications au projet à l’aide de votre éditeur de texte favori, comme Visual Studio Code. 
Quand vous êtes prêt à soumettre vos modifications, indexez-les et commitez-les. git add . indique à Git que vous voulez inclure toutes vos modifications dans le commit suivant. git commit prend un instantané de ces modifications.

Commande: 
```
git add .
git commit -m "a short description of the change"
```

Quand vous indexez et commitez des fichiers, vous indiquez grosso modo à Git de prendre un instantané de vos modifications. Vous pouvez continuer à apporter d’autres modifications et prendre d’autres instantanés de commit.

Pour le moment, vos modifications existent uniquement en local. Quand vous êtes prêt à pousser (push) vos modifications vers GitHub, poussez-les vers le dépôt distant.

Commande: 
```
git push
```

### Faire des pull request

Enfin, vous voilà prêt à proposer des modifications dans le projet principal ! . Si vous avez apporté une modification qui, à votre avis, pourrait être bénéfique pour l’ensemble de la communauté, envisagez sérieusement d’apporter votre contribution.

Pour cela, accédez au dépôt GitHub où réside votre projet. Vous allez voir une bannière indiquant que votre branche a un commit d’avance. Cliquez sur Contribuer, puis Ouvrir pull request.

GitHub vous fait accéder à une page qui indique les différences entre votre duplication (fork) et le dépôt TodoList. Cliquez sur Create pull request.

GitHub vous fait accéder à une page dans laquelle vous pouvez entrer le titre et la description de vos modifications.Enfin, cliquez sur Create pull request.

### Conventions de codage :

Le projet suit les bonnes pratiques des PSR-1 et 12 :

  - PSR-1 : https://www.php-fig.org/psr/psr-1/
  - PSR-12 : https://www.php-fig.org/psr/psr-12/

### Conventions de nommage :
- nommez vos variables, fonctions et arguments en camelCase
- utilisez des namespaces pour toutes vos classes et nommez les en UpperCamelCase

### NB : 
Avant de commencer à travailler sur un changement, regarder si quelqu’un n’est pas déjà dessus en vérifiant s’il n’existe pas déjà une pull request.

