Spark Framework Bundle
======================


This bundle is designed to provide you a summary of your deployed applications and your standalone bundles.  

----------

Doctrine
--------------
> **Dependencies:**

   > - Doctrine\Common\Cache\CacheProvider
   > - Doctrine\ODM\MongoDB\DocumentRepository
   > - Doctrine\ODM\MongoDB\Repository\RepositoryFactory

Details
--------
> **CacheableDocumentRepository:**
This class is a base repository class for MongoDB object. It provides a cache provider access to store query results for instance.
> **CacheableDocumentRepositoryFactory:**
This factory will return the repository class for a MongoDB object. It will be a DocumentRepository or CacheableDocumentRepository depending on your configuration.

Configuration
-------------
You can set both CacheableDocumentRepository as parameters in your dependency injection container, create a service for CacheableDocumentRepositoryFactory and configure doctrine_mongodb this way:

```
#!yml
doctrine_mongodb:
    connections:
        default:
            server: mongodb://%mongodb_host%:%mongodb_port%
            options: %mongodb_options%
    default_database: %mongodb_database%
    document_managers:
        default:
            auto_mapping: true
            default_repository_class: %document_repository_default_class%
            repository_factory: # Your service here
```