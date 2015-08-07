Spark Framework Bundle
======================


This bundle is designed to provide core components for your bundles.  

----------

Requirements
-----------------
> **This bundle relies on the following:**

   > - Symfony 2.7.*

Bundle Parameters
--------------------------

```
#!yml
spark_framework.form.factory.class: Spark\FrameworkBundle\Form\Factory\FormFactory
spark_framework.component.scrambler.class: Spark\FrameworkBundle\Component\Scrambler
spark_framework.component.otp_generator.class: Spark\FrameworkBundle\Component\OTPGenerator
```


What it provides
-----------------
It provides various components:
> **Component:**

 > - *HttpFoundation*:

   >> - PublicResponse

 > - GrouperInterface
 > - IpTools
 > - JsonValidator
 > - Logger (made by Benoit MAZIERE)
 > - Memory
 > - OTPGenerator
 > - OTPGeneratorInterface
 > - Scrambler
 > - ScramblerInterface
 > - StringUtilities

> **DataFixtures:**

 > - DataFixturesLoader

> **Dependency Injection:**

 > - OTPGeneratorCompilerPass
 > - ScramblerCompilerPass

> **Doctrine:**

  >> - *ODM:*

   >>> - MongoDB:

   >>>> - CacheableDocumentRepository
   >>>> - CacheableDocumentRepositoryFactory

> **Event:**

  >> - *Subscriber:*

   >>> - Doctrine:

   >>>> - TablePrefixSubscriber

   >>> - Sortable:

   >>>> - Doctrine:

   >>>>> - ArrayCollectionSubscriber

   >>>> - SortableSubscriber

> **Exception:**

  >> - NotImplementedException

> **Form:**

  >> - *Factory:*

   >>> - FormFactory

> **Request:**

  >> - *ParamConverter:*

   >>> - MultiCollectionsParamConverter

> **Traits:**

  >> - ConnectionLogger
  >> - HexadecimalValidator
  >> - Logger
  >> - PDOTablePrefix

> **Validator:**

  >> - *Constraints:*

   >>> - UniqueDocument
   >>> - UniqueDocumentValidator

Acknowledgements
-----------------------
I would like to thank Friends of Symfony for their FormFactory class, it has been an inspiration for designing Form Handler. 

A special thank you for Benoit Maziere who developed a lightweight logger and allowed me to integrate it within this bundle.