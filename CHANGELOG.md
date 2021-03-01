# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0] - 2021-03-01

### [Added]

- PHP 8.0 support and syntax

### [Removed]

- PHP < 8.0 support
- deprecated `Basster\LazyResponseBundle\Response\AbstractLazyHttpResponse::getStatus()` method.

### [Fixed]

- Dependabot issues since today.

## [1.2] - 2020-02-23

### [Added]

- Yey, a Changelog! ;)

### [Deprecated]
- AbstractLazyHttpResponse::getStatus() is deprecated, use AbstractLazyHttpResponse::getStatusCode() instead.

## [1.1.1] - 2019-10-04

- add status code getter to lazy response interface
