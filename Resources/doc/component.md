Spark Framework Bundle
======================


This bundle is designed to provide you a summary of your deployed applications and your standalone bundles.  

----------

Component
--------------
> **Dependencies:**

   > - Symfony\Component\HttpFoundation\Request
   > - Symfony\Component\HttpFoundation\RequestStack

Details
--------
> **PublicResponse:**
This class extends Response, set it public and defines maxAge and sharedMaxAge headers.
> **GrouperInterface:**
GrouperInterface is an interface designed to propose object grouping implementation based on a simple or composed key.
> **IpTools:**
This class provides methods to determine whether a client is behind a detectable proxy or behind the onion router (TOR). In addition, it provides a method to get the real IP.
> **JsonValidator:**
C'est une classe qui expose une méthode publique permettant de vérifier la validité d'une chaîne json.
> **Logger:**
This class provides a lightweight logger. It implements LoggerInterface.
This class was made by [Benoit MAZIERE](mailto:benoit.maziere@gmail.com?subject=Logger)
> **Memory:**
This class exposes two public static methods.
The first one, named "memoryUsage" returns the memory usage of a script at the current moment. It is suffixed by a readable unit (Byte, KiloByte, MegaByte, GigaByte, TeraByte, PetaByte).
The second one, named "memoryPeak" returns a string with the peak usage of memory for a script with a readable unit (Byte, KiloByte, MegaByte, GigaByte, TeraByte, PetaByte).
> **OTPGenerator / OTPGeneratorInterface:**
OTPGenerator is an interface designed to be implemented for generating a unique password.
The OTPGenerator class is an implementation of the interface. It takes a 32 bytes key (64 hexadecimal characters), time window and an algorithm.
This class is able to generate a unique one time password during a time window. It can be helpful for two-factors authentication for instance.
> **Scrambler / ScramblerInterface:**
ScramblerInterface is an interface designed to create implementation for encrypting and decrypting a string.
The Scrambler class is an implementation of the interface. This class encrypt and decrypt string thanks to a 32 bytes key (64 characters) and a sha256 algorithm.
> **StringUtilities:**
This class exposed several methods, such as, a method to get the filename from a string without its extension, a method to slugify a string and another method designed to replace white spaces by a character.