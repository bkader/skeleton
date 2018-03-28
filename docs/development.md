I have been asked this question **a lot**:  
> *How is it possible to develop all kind of website with only **9** tables?*

I am going to discuss few ideas here. If you cannot find yours here, simply head to our <a href="https://www.facebook.com/groups/ci.skeleton/" target="_blank">Facebook Group</a>, tell us what it is and once we find a good logic, we will reply to you there and add your idea here.

## Social Network

To develop a social network, develop your desired modules the way you want, then, let's talk about some possible features.  
To start, it is obvious that:  

* **Users** are stored in **entities** and **users** tables.
* **Groups** or **Pages** are stored in **entities** and **groups** tables.
* **Posts** (no matter what type) are stored in **entities** and **objects** tables.

No the fun part, features.

**Like System**  
Likes can be stored in the **relations** table where **guid_from** holds the user who likes, **guid_to** hold the post, page or any likable thing on the application.

**Friend Requests**  
Friend requests can be stored, as well, in **relations** table (let's ignore IDs, we already talked about them), where **relation** field holds the type of relation. Example:  

* **friend_request**: to say that the user sent a friend request.
* **request_accepted**: whether to update the **friend_request** relation or create a new one, to tell that the receiver accepted the request.

**Comments System**  
Comments are objects (*entities* + *objects*), if you checked the entities documentation, you may have noticed the **parent_id** and **owner_id** fields, right? What do you?  

* **owner_id**: holds the owner of the comment/post/thread.
* **parent_id**: Under which post/comment/tread this comment is listed.

**Messaging System**  
The same as posts and comments, messages are **objects**, of course with **owner_id** (the sender) and the **parent_id** (the receiver) ... If you wish you organize them under conversations, you may create a new **group** of subtype **conversation** under which you gather all messages (objects). Got it?  
If the owner deletes the message, you may for example add a metadata named **sender_deleted** and set its value to `TRUE`, so messages with that metadata are not displayed to sender, and vice versa.

**Profile Details**  
What do you thing **metadata** were created for? Use them :D.

**Privacy System and Access level**  
Sometime you want post to appear to followers only, or friends, if you have checked, again, entities documentation, you have probably noticed the **privacy** column, right? Use it :smile: (to known more about it, head to entities documentation > Table Structure > privacy).

**Account History**  
Didn't you notice the **activities** table and its library? Do I have to explain? :smile:

Satisfied? Not yet!!! What else? Just tell me about it and I will add it.

## E-Commerce

What's needed on an e-commerce application?  

* Products list (**objects**).
* Products categories (**groups**) and their details and settings (**metadata**).
* Clients (**users**) and their details (**metadata**).
* Shopping Carts (**variables** or **metadata**). by I prefer variables because as I said, they are temporary data, by you can use **metadata** if you which to keep them. OR better, use **variables**, when a shopping cart is concluded, transfer it to **metadata**.

A products may have:

* price (**metadata**);
* images (related **objects**);
* categories (related **groups**);
* orders count (**metadata**);
* stock quantity (**metadata**);

Satisfied? Not yet!!! What else? Just tell me about it and I will add it.

## Content Management System

What does a CMS needs?  

* Categories (**groups**).
* Posts and Pages (**objects**).
* Posts to Categories relations (**relations**).

All of these may have custom fields (think of WordPress). You may simply store them in **metadata** if they are permanent, of **variables** if you wish to delete them after a while.  

**Revisions**  
The cool feature on WordPress is that it creates revisions when editing posts, right? Why not duplicate the current post and set it as "revision" ... I let you use your imagination.

Satisfied? Not yet!!! What else? Just tell me about it and I will add it.

## Q&A Website

What does it need?  

* Categories (**groups**) and their details (**metadata**).
* Questions (**objects**) and their answers (**objects**).
* Users (**users**) and their points (**metadata**).

What else?

Satisfied? Not yet!!! What else? Just tell me about it and I will add it.