[![Build Status](https://travis-ci.org/nerdial/standard-versioning.svg?branch=master)](https://travis-ci.org/nerdial/standard-versioning)

# Installing Package through composer

## Globally
```sh
$ composer global require nerdial/standard-versioning
```
## Or in root of a project

```sh
$ composer require nerdial/standard-versioning
```
### if you choose the ladder option, then you need to call composer's bin folder like the following :
```sh
$ ./vendor/bin/moon 
```


# Available Commands


### Initiate versioning process

> This command will create a default tag for initiation

```sh
$ moon init
```

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