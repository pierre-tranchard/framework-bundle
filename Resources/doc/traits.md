Spark Framework Bundle
======================


This bundle is designed to provide you a summary of your deployed applications and your standalone bundles.  

----------

Traits
-------
> **Dependencies:**

   > - DoctrineBundle
   > - Psr\Log\LoggerInterface
   > - Symfony\Component\Console\Output\OutputInterface

Details
--------
> **ConnectionLogger:**
Trait made to disable Doctrine Connection Logger to null easily
> **HexadecimalValidator:**
Trait made to validate a 32 bytes string (64 characters)
> **Logger:**
Trait made to easily use the lightweight logger made by [Benoit MAZIERE](mailto:benoit.maziere@gmail.com?subject=Logger), ensuring the file exists & so on
> **PDOTablePrefix:**
Trait made to get table name with table prefix if defined for queries through Doctrine Connection instead of Entity Manager.