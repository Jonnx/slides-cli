# slides-cli

A cli designed to steamline the creation of recurring reports & slides.

## Commands

### `images:fetch` download a list of images

This command fetches a series of images from the internet and neatly organizes them inside a directory to be used in your slide decks, documentation, or anything else really.

```
slides images:fetch ./path/to.yaml
```

##### YAML File Example:
```
my-report:
  placeholder-150.png: https://via.placeholder.com/150
  placeholder-300.png: https://via.placeholder.com/300
```

This will generate a directory called `my-report` in your current directory and download two placeholder images and place them in the folder with the name given as the key in the configuration file.

## Development

### Getting Started
Install dependencies with

```
composer install
```

the run the cli with

```
./slides
```

You should be greeted with the following welcome screen
```

  
  _____ _ _     _            _____ _      _____ 
 / ____| (_)   | |          / ____| |    |_   _|
| (___ | |_  __| | ___  ___| |    | |      | |  
 \___ \| | |/ _` |/ _ \/ __| |    | |      | |  
 ____) | | | (_| |  __/\__ \ |____| |____ _| |_ 
|_____/|_|_|\__,_|\___||___/\_____|______|_____|
                                                
                                                

  unreleased

  USAGE: slides <command> [options] [arguments]

  completion   Dump the shell completion script
  inspiring    Display an inspiring quote
  test         Run the application tests

  app:build    Build a single file executable
  app:install  Install optional components
  app:rename   Set the application name

  images:fetch download a series of images from yaml file

  make:command Create a new command

  pest:dataset Create a new dataset file
  pest:install Creates Pest resources in your current PHPUnit test suite
  pest:test    Create a new test file

  stub:publish Publish all stubs that are available for customization
```

This cli is developed with https://laravel-zero.com/. Check out their documentation for capabilitie, limitations, and detailed implementation examples.

### Building the CLI
You can build the cli with:
```
composer make
```

This will build the phar archive and move it to the `~/bin/slides` path. Make sure to add `~/bin` to you path so you can use the cli anywhere on your machine easily.

#### Setting Path Example
You could add the following line to the `~/.bash_profile` file:

```
export PATH="~/bin:$PATH"
```