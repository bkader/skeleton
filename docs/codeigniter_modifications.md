# CodeIgniter Modifications

Few modifications, enhancement and rewriting have been done to suit the need of the application. Those are few to none change but we have to mention them due to license agreement and so that you know what to do in case of a new CodeIgniter release.

## index.php

Two constants have been added:  
* **KBPATH**: which holds the path to the skeleton files (line: **251**). 
* **DS**: Which is a simple constant representing **DIRECTORY_SEPARATOR** (line: **254**). 

## CodeIgniter.php

At line **79**, you may notice that we have loaded my own __constants.php__ file that contains extra useful constants. Note that some of them were directly borrowed from WordPress.

At line **211**, loading the config class was moved above the hooks class because this one is loading it in its class constructor. So why load it twice?

At line **227**, you will that we have loaded the plugins class to make its helpers available earlier. This class was, again, inspired from WordPress and thanks to it, the whole application took a really nice detour.

In the controllers loading section, line **427**, you will see that we change few lines to allow the application to search inside __skeleton/controllers__ folder in case no controller was found in the default location (which is obviously __application/controllers__).

Wherever there is hook called, we used __do_action(HOOK)__ function right after, this way, future themes and plugins or even other application folders will have access to it.


## Common.php

This file was edited in two (2) places but on the same function, __load_class()__. we simply added the **KBPATH** constant (see: __index.php__ section) to allow searching for core files not only in default folders (__application/core__ and __system/core__). In order, classes will be looked for in APPPATH, KBPATH then finaly BASEPATH (see line:**155**).

At line **175**, you notice that we are loading our custom files as soon as the class is called. These classes will have the **KB_** prefix to allow you use any subclass prefix for your application.

## Lang.php

We added the CI_Config to class constructor to avoid load config file again because it is already loaded.

## KB_Config.php

## KB_Controller.php

## KB_Lang.php

## KB_Loader.php

This class is here so we can use HMVC structure. Some of its methods are there to complete, enhance or override CodeIgniter's Loader.php file.

## KB_Router.php

Because we are using HMVC structure, this class comes handy and handles perfectly routes and requests.

## KB_Model.php
