Spark Framework Bundle
======================


This bundle is designed to provide you a summary of your deployed applications and your standalone bundles.  

----------

Validator
-------
> **Dependencies:**

   > - DoctrineMongoDBBundle
   > - Symfony\Component\PropertyAccess\PropertyAccess
   > - Symfony\Component\Validator\Constraint
   > - Symfony\Component\Validator\ConstraintValidator

Details
--------
> **UniqueDocument:**
Class constraint made for MongoDB documents allowing to defined a unique constraint based on one or several property (and sub properties)
> **UniqueDocumentValidator:**
Class designed to validate the UniqueDocument constraint using the MongoDB Manager Registry