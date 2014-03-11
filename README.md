CouchbaseBundle
===============

This bundle creates a Symfony2 integration for Couchbase. It currently adds commands to make it easier to
automate import and export of design documents, stored in Couchbase and adds all Couchbase actions to the timeline in
the Symfony2 profiler.

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

To configure the couchbase-cluster, you want to use in your application, please adjust the parameters as needed. Here's
a list of the available parameters and their default-value:

```yaml
couchbase.host: localhost
couchbase.username:
couchbase.password:
couchbase.bucket:
couchbase.persistent: true
```

**Info:** Currently it's just possible to have one instance of Couchbase running at the same time. Feel free to create a
pull-request if you need to support more.

## Using commands

You should see a couple of new methods in your symfony console:

* couchbase:export-ddoc - to export design-documents, stored in your couchbase-cluster, to files
* couchbase:import-ddoc - to import design-documents, saved as file, into your couchbase-bucket
* couchbase:import-docs - to import couchbase documents, saved as file, into your couchbase-bucket

When importing documents from the filesystem to the database, it additionally checks if the folder, you defined, also
contains a folder having the same name as your environment. If found, the documents in there are imported as well.

More to come ...

**Setup**

In order to use the command couchbase:import-docs, you first have to create a view called "get_all_docs" in a document
called "sf2_couchbase_bundle" whose map-function looks just like this:

```javascript
function (doc, meta) {
  emit(meta.id, null);
}
```

**Example usage**

    app/console couchbase:import-ddoc
Will import all files found in app/Resouces/\*.ddoc and  app/Resouces/dev/\*.ddoc

    app/console couchbase:import-ddoc -e test
Will import all files found in app/Resouces/\*.ddoc and  app/Resouces/test/\*.ddoc

    app/console couchbase:export-ddoc
Will save all design-documents, found in couchbase, to the folder app/Resouces/ in files having the file-extension *.ddoc*

## Using the profiler for Couchbase

You can activate the stopwatch for every Couchbase-call by adding the following lines to your configuration:

```yaml
simonsimcity_couchbase:
    profiler_enabled: true
```

My personal recommendation is to add these lines to your [`config_dev.yml`] file.