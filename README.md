CouchbaseBundle
===============

This bundle creates a Symfony2 integration for Couchbase. It currently adds commands to make it easier to
automate import and export of design documents, stored in Couchbase and adds all Couchbase actions to the timeline in
the Symfony2 profiler.

It requires the pecl module for couchbase in 2.0.7.

## Installation

Require [`simonsimcity/couchbase-bundle`](https://packagist.org/packages/simonsimcity/couchbase-bundle)
into your `composer.json` file:


``` json
{
    "require": {
        "simonsimcity/couchbase-bundle": "dev-master"
    }
}
```

Register the bundle in your Kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Simonsimcity\CouchbaseBundle\SimonsimcityCouchbaseBundle(),
        // ...
    );
}
```

To configure the couchbase-cluster, you want to use in your application, please adjust the settings for the extension as
needed. Here's a sample-configuration for two buckets (`foo` and `bar`) on a local cluster (the cluster available as a
service called `couchbase.cluster.main`) by the service names `couchbase.bucket.main_foo` and `couchbase.bucket.bar`,
where the second bucket is secured by the password `123`:

```yaml
simonsimcity_couchbase:
    cluster:
        main:
            dsn: http://127.0.0.1/
            username: root
            password: foo

            buckets:
                main_foo:
                    name: foo
                bar:
                    name: bar
                    password: 123
```

## Using commands

You should see a couple of new methods in your symfony console:

* couchbase:export-ddoc - to export design-documents, stored in your couchbase-cluster, to files
* couchbase:import-ddoc - to import design-documents, saved as file, into your couchbase-bucket
* couchbase:export-docs - to export couchbase documents, saved in your couchbase-bucket as files
* couchbase:import-docs - to import couchbase documents, saved as file, into your couchbase-bucket

When importing documents from the filesystem to the database, it additionally checks if the folder, you defined, also
contains a folder having the same name as your environment. If found, the documents in there are imported as well.
If the name of the folder for design-documents contains the characters `{connection}`, they are replaced by the name of
the selected couchbase-connection.

More to come ...

**Setup**

In order to use the command couchbase:import-docs, you first have to create a view called `get_all_docs` in a document
called `sf2_couchbase_bundle` whose map-function looks just like this:

```javascript
function (doc, meta) {
  emit(meta.id, null);
}
```

**Example usage**

    app/console couchbase:export-ddoc foo
Will save all design-documents, found in the couchbase-definition `foo`, to the folder `app/Resouces/foo/` in files
having the file-extension `.ddoc`

    app/console couchbase:import-ddoc -e test foo
Will import all files found in `app/Resouces/foo/\*.ddoc` and  `app/Resouces/foo/test/\*.ddoc`. My recommendation is to
create a file called `sf2_couchbase_bundle.ddoc` in the `test` folder so you'll always have that view available in your
test environment.

    app/console couchbase:export-docs foo data/
Will export all documents of your `foo` bucket to `app/data/`

    app/console couchbase:import-docs foo data/
Will import all files, having the extension `.json` into your defined `foo` couchbase-bucket

## Using the profiler for Couchbase

You can activate the stopwatch for every Couchbase-call by adding the following lines to your configuration:

```yaml
simonsimcity_couchbase:
    profiler_enabled: true
```

My personal recommendation is to add these lines to your `config_dev.yml` file.