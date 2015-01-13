#Hater App

An app for letting your worst thoughts about anything get out in a easy manner.
##Directory structure

```
  /
    /app -> app code, not visible by anyone
      /src -> core app code
      /templates -> Twig templates for the views.
    /3rd_party -> 3rd party libraries.
      composer.json -> dependency declaration
      composer.lock -> dependency version lock
      /vendor -> Here goes all the vendor code
    /public -> Public data
      index.php -> Entry point
      /css
      /js
      /img
      /fonts
```