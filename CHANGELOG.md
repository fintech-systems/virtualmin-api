# Virtualmin API Change Log

All notable changes to `virtualmin-api` will be documented in this file.

## v0.1.5 - 2022-02-14

- FIX: Check if actual output is returned on getDomains() before looping (PR-23)

## v0.1.4 - 2022-02-06

- Add the domain ID to the domain info (PR #19)
- Update contributors in README

## v0.1.3 - 2022-02-03

- Change scope of runProgram to public

## v0.1.2 - 2022-01-26

- Added ability to create domain

## v0.1.1 - 2021-10-29

- Changed the WGET command that was run using a shell to native PHP CURL
- Improved README examples by adding name spacing and adding get and list plans as features
- Added Fabio as contributor

## 0.1.0 - 2021-09-10

First test version that include live server testing, offline testing, and list domains and get domains commands.

There is also a Laravel Service Provider