# Bkader Activities Driver (Bkader_activities)

You can find this file inside your __application/libraries/Bkader__ folder.

## Library Methods.

This class has only few methods.

### initiliaze()

This method is called on the parent's __constructor__. It was added only to make sure the class is initialized and off course to make its function helper available on the whole application.

### log_activiti($user_id, $activity)

Like its name says, it simply records a new user activity. It will automatically hold the module's name if any, the controller's name and the method's name for you. It also holds the ip address of the user.
