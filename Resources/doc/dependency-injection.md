Spark Framework Bundle
======================


This bundle is designed to provide you a summary of your deployed applications and your standalone bundles.  

----------

Dependency Injection
--------------------
> **Dependencies:**

   > - Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface

Details
--------
> **OTPGeneratorCompilerPass:**
This class look-up for "spark_framework.component.otp_generator_clients" parameter in the dependency injection container, and will dynamically create instance of OTP Generator class (or instance of specified class describe using "spark_framework.component.otp_generator.class" parameter in the container). These instances will be referenced as service.
> **ScramblerCompilerPass:**
This class look-up for "spark_framework.component.scrambler_clients" parameter in the dependency injection container, and will dynamically create instance of Scrambler class (or instance of specified class describe using "spark_framework.component.scrambler.class" parameter in the container). These instances will be referenced as service.