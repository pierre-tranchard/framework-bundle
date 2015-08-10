Spark Framework Bundle
======================


This bundle is designed to provide you a summary of your deployed applications and your standalone bundles.  

----------

Event
-----
> **Dependencies:**

   > - KNPPaginatorBundle
   > - Doctrine\Common\Collections\ArrayCollection
   > - DoctrineBundle

Details
--------
> **TablePrefixSubscriber:**
This class subscribes to doctrine's events and add a table prefix on entity manager queries (table prefix has to be defined as parameter in the dependency injection container with the name table_prefix) 
> **ArrayCollectionSubscriber:**
This class allows to sort objects stored in ArrayCollection. This subscriber is designed to work with KNP Paginator Bundle
> **SortableSubscriber:**
This class is a service designed to register the ArrayCollection Subscriber.