[![Build Status](https://travis-ci.org/nerdial/standard-versioning.svg?branch=master)](https://travis-ci.org/nerdial/standard-versioning)

# Installing Package through composer

## Globally
```sh
$ composer global require nerdial/standard-versioning
```
## Or in a root of a project

```sh
$ composer require nerdial/standard-versioning
```
### if you choose the ladder option, then you need to call composer's bin folder like the following :
```sh
$ ./vendor/bin/moon 
```


# Available Commands


### Initiate versioning process

> This command creates a config file called moon.yaml, then creates the first tag and commit to the git 

```sh
$ moon init
```
Options
Name | Shortcut | Value | Default| Description 
--- | --- | --- | --- | ---
 --start-from | -s | 0.0.1 | 0.1.0 | if you have already a git repository with some tags you should tell the package which version you are in.
--tag-format | -f | v , V or whatever prefix you prefer , you could even pass empty string '' without space in between quotes to have no prefix in your tag name | v | tag format tells that what prefix should be added to the begining of tag name. by default it uses semvar structure like v1.0.0


### Create new tag version

> This command will create a new tag in your git repository

```sh
$ moon tag major|minor|patch -m "Add new version"
```

### Create a github release and push it to repo

> This command will create a new tag in your git repository

```sh
$ moon release --token "github personal token"
```

### Create a CHANGELOG.md file in the root direcotry

> This command will create a new tag in your git repository

```sh
$ moon changelog
```
