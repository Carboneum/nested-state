# Nested state

[![Build Status](https://travis-ci.org/Carboneum/nested-state.svg?branch=master)](https://travis-ci.org/Carboneum/nested-state)
[![Code Climate](https://codeclimate.com/github/Carboneum/nested-state/badges/gpa.svg)](https://codeclimate.com/github/Carboneum/nested-state)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Carboneum/nested-state/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Carboneum/nested-state/?branch=master)
[![Test Coverage](https://codeclimate.com/github/Carboneum/nested-state/badges/coverage.svg)](https://codeclimate.com/github/Carboneum/nested-state/coverage)
[![Issue Count](https://codeclimate.com/github/Carboneum/nested-state/badges/issue_count.svg)](https://codeclimate.com/github/Carboneum/nested-state)

Class to model parametric state object. State is an object defined by hash of scalar values with scalar (string) keys.
Each key of hash must be defined from the beginning, but some value for keys could be equal null to represent undefined
state. One can change values for state parameters during state object lifetime, but cannot add new parameters.

## Operations

For state object two operations are defined.

### Matching

First is check if state object matches to separate parameters set. State matches to parameter set if all of set's
parameters have the same values as corresponding parameters in the state.

For example:

```php
$state = new State(['foo' => 1, 'bar' => true, 'olo' => null]);

var_export($state->matches(['foo' => 1])); // true

var_export($state->matches(['foo' => 1, 'olo' => 3])); // false

var_export($state->matches(['foo' => 1, 'bar' => false])); // false

var_export($state->matches([]); // true

```

Trying to match state object to parameters that are not defined in it will cause an Exception:

```php

$state = new State(['foo' => 1, 'bar' => 2, 'olo' => null]);

// will cause an exception
var_export($state->matches(['foo' => 1, 'boo' => 5]));

```

### Weight

Weight is a property of match. Weight defines specificity level of match. All parameters defined in constructor
are ranged from less specific to more specific. If you add matching parameter to set you will have more specific match.

For example:

```php
$state = new State(['foo' => 1, 'bar' => true, 'olo' => null]);

var_export($state->getMatchWeight(['foo' => 1]));
// is greater then
var_export($state->getMatchWeight(['bar' => true]));

var_export($state->getMatchWeight(['foo' => 1, 'bar' => true]));
// is greater then
var_export($state->getMatchWeight(['foo' => 1]));

var_export($state->getMatchWeight(['foo' => 1, 'bar' => 'baz'])); // false

```


