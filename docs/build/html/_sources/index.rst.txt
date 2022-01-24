.. FTPoverHTTP documentation master file, created by
   sphinx-quickstart on Mon Jan 24 12:20:44 2022.
   You can adapt this file completely to your liking, but it should at least
   contain the root `toctree` directive.

Welcome to FTPoverHTTP's documentation!
=======================================

.. toctree::
   :maxdepth: 2
   :caption: Contents:



Indices and tables
==================

* :ref:`genindex`
* :ref:`modindex`
* :ref:`search`


Elements
==================

.. php:class:: v2/elements

	Elements is used when the method can be used by a directory or a file.

	All the method can be used in the files and dirs section.


	.. php:method:: rename()

		Rename an element to an other name.

		Need to use the POST HTTP method.

		:param: 'path' : the path where the element is.
		:param: 'previousName' : the previous name of the element.
		:param: 'newName' : the new name of the element.
		:returns: HTTP Response.



Files
==================

.. php:class:: 	v2/files


	.. php:method:: index()

		HTTP request method GET, DELETE or PUT.

		In function of the request methode, this will call the function get, delete or put.


		.. note:: link : http://localhost/codeIgniter3/v2/files

	.. php:method:: get()

		Get a file from the FTP Server.

		Need to use the GET HTTP methode.

		This methode is private, you need to pass by the index methode ( http://localhost/codeIgniter3/files ).

		:param: 'path' The path to the file
		:returns: HTTP Response



	.. php:method:: delete()

		Delete a file from the FTP Server.

		Need to use the DELETE HTTP methode.

		This methode is private, you need to pass by the index methode ( http://localhost/codeIgniter3/files ).

		:param: 'path' : The path to the file
		:returns: HTTP Response

		::

				HTTP/1.1 204 OK

		.. note:: Error will send a 400 or more code error and a JSON Object with the error message.


	.. php:method:: put()

		Put a file in the FTP Server.

		Need to use the PUT HTTP methode.

		This methode is private, you need to pass by the index methode ( http://localhost/codeIgniter3/files ).

		:param: 'path' : The path to the directory where you want the file to be in.
		:param: 'file' : The file to be uploaded
		:returns: HTTP Response

		::

				HTTP/1.1 201 Created

		.. note:: Error will send a 400 or more code error and a JSON Object with the error message.


  .. php:method:: move()

		Move a file from a directory to another.

		Need to use the POST HTTP methode.

		:param: 'pathSrc' : The path to the directory where the file is.
		:param: 'pathDst' : The path to the directory where you want to move the file.
		:param: 'filename' : The name of the file.

		Accessible by : http://localhost/v2/files/move


Dirs
==================

.. php:class:: v2/dirs

	.. php:method:: index()

		Accessible with HTTP request method POST, GET or DELETE.

		In function of the request methode, this will call respectively the function mkdir, ls or rmdir.

	.. php:method:: mkdir()

		Create a new directory.

		:param: 'path' : The path with the new directory include.
		:returns: HTTP Response

	.. php:method:: rmdir()

		Remove a directory.

		This will remove all the files and directory inside the directory who is deleted.

		:param: 'path' : The path with the directory to remove include.
		:returns: HTTP Response

	.. php:method:: ls()

		List all the directory and the file name

		If no path has been precised, this will send the result command with the current directory (.).

		:param: 'path' : The path to list all the file and directory names
		:returns: HTTP Response with JSON Object

		::

			Example :
			[
				"Directory1",
				"Directory2",
				"File1.txt",
				"File2.txt",
				"File3.txt"
			]

		..

	.. php:method:: lsl()

		List all the directory and the file with more information than "ls()" function.

		If no path has been precised, this will send the result command with the current directory (.).

		:param: 'path' : The path to list all the file and directory names
		:returns: HTTP Response with JSON Object

		::

			Example :
			[
				{
					"name":"Directory1",
					"size":"138",
					"type":"dir",
					"perm":"el",
					"modify":"20220121153436"
				},
				{
					"name":"Directory2",
				 	"size":"3093195",
				 	"type":"dir",
				 	"perm":"el",
				 	"modify":"20220121153436"
				},
				{
					"name":"File1.txt",
					"size":"18",
					"type":"file",
					"perm":"r",
					"modify":"20220124140956"
				},
				{
					"name":"File2.txt",
					"size":"111",
					"type":"file",
					"perm":"r",
					"modify":"20220124141018"
				},
				{
					"name":"File3.txt",
					"size":"71",
					"type":"file",
					"perm":"r",
					"modify":"20220124141051"
				}
			]

		..
	.. php:method:: pwd()

		Return the current path to the current directory

		Need to use the GET HTTP method.

		:returns: HTTP Response with JSON Object

		::

			{
				"pwd":"/"
			}

		..
