[![Build Status](https://travis-ci.org/stewe/silex-example.png?branch=master)](https://travis-ci.org/stewe/silex-example)

This is just an example of Silex usage with unit and functional testing.
It sends an email upon a POST request to a url like /{slug}, where slug
is a directory in views with a customer.html.twig inside it.

Just run php composer.phar install to gets the project running.

Ex:
curl --data "foo=dummy" http://acme.dev/example1