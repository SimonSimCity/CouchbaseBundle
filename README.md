CouchbaseBundle
===============

Adds two Symfony commands to make it easier to automate import and export of design documents, stored in couchbase.

The installation for this bundle is like any other.

After installing this bundle, you'll see two new methods in your symfony console:

* couchbase:export-ddoc - to export design-documents, stored in your couchbase-cluster, to files
* couchbase:import-ddoc - to import design-documents, saved as file, into your couchbase-bucket
* couchbase:import-docs - to import couchbase documents, saved as file, into your couchbase-bucket

When importing documents from the filesystem to the database, it additionally checks if the folder, you defined, also
contains a folder having the same name as your environment. If found, the documents in there are imported as well.

More to come ...

**Installation**

In order to use the command couchbase:import-docs, you first have to create a view called _get_all_docs_ in a document
called _sf2_couchbase_bundle_ whose map-function looks just like this:

´´´
function (doc, meta) {
  emit(meta.id, null);
}
´´´

**Example**

    app/console couchbase:import-ddoc
Will import all files found in app/Resouces/\*.ddoc and  app/Resouces/dev/\*.ddoc

    app/console couchbase:import-ddoc -e test
Will import all files found in app/Resouces/\*.ddoc and  app/Resouces/test/\*.ddoc

    app/console couchbase:export-ddoc
Will save all design-documents, found in couchbase, to the folder app/Resouces/ in files having the file-extension *.ddoc*
