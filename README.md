[![Build Status](https://travis-ci.org/nerdial/standard-versioning.svg?branch=master)](https://travis-ci.org/nerdial/standard-versioning)

# Installing Package

```sh
$ composer global require nerdial/standard-versioning
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