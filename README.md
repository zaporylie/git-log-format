# git-log-format

[![Build Status](https://travis-ci.org/violinist-dev/git-log-format.svg?branch=master)](https://travis-ci.org/violinist-dev/git-log-format)
[![Coverage Status](https://coveralls.io/repos/github/violinist-dev/git-log-format/badge.svg?branch=master)](https://coveralls.io/github/violinist-dev/git-log-format?branch=master)
[![Violinist enabled](https://img.shields.io/badge/violinist-enabled-brightgreen.svg)](https://violinist.io)


A convenience package to get formatted versions of the output of git log --oneline.

This is part of what powers the changelogs in the messages from Violinist.io.

## Installation

```bash
composer require violinist-dev/git-log-format
```

## Usage

Somehow get a string output from a git log. A command line way to do so is the following:

```bash
git log abababa..fefefef --oneline
```

In the above example, abababa and fefefef are both hashes in the commit history.

The output would be somewhat like this:

```
fefefef Fix bugs and add tests
cdcdcdc Release features and probably introduce bugs

```

Then, pass the output to this package:

```php
$data = 
```
