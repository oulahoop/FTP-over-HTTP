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


	.. php:method:: v2/elements/rename [POST]

		Rename an element to an other name.

		:param: 'path' : the path where the element is.
		:param: 'previousName' : the previous name of the element.
		:param: 'newName' : the new name of the element.
		:returns: HTTP Response.

		::

				< HTTP/1.1 200 OK
				< Date: Mon, 24 Jan 2022 23:35:06 GMT
				< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
				< X-Powered-By: PHP/8.0.14
				< Content-Length: 0
				< Content-Type: text/html; charset=UTF-8

		..


Files
==================

.. php:class:: 	v2/files


	.. php:method:: v2/files

		HTTP request method GET, DELETE or PUT.

		In function of the request methode, this will call the function get, delete or put.


		.. note:: http://localhost/codeIgniter3/v2/files

	.. php:method:: v2/files [GET]

		Get a file from the FTP Server.

		Need to use the GET HTTP methode.

		This methode is private, you need to pass by the index methode ( http://localhost/codeIgniter3/files ).

		:param: 'path' The path to the file
		:returns: HTTP Response

		::

			< HTTP/1.1 200 OK
			< Date: Mon, 24 Jan 2022 23:22:13 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Cache-Control: public
			< Content-Transfer-Encoding: Binary
			< Content-Length: 103
			< Content-Disposition: attachment; filename=OurAPI.txt
			< Content-Type: application/text/plain
			<
			Our REST API is called FTP over HTTP.
			From HTTP Request, we "translate" them to request the FTP server.

		..



	.. php:method:: v2/files [DELETE]

		Delete a file from the FTP Server.

		Need to use the DELETE HTTP methode.

		This methode is private, you need to pass by the index methode ( http://localhost/codeIgniter3/files ).

		:param: 'path' : The path to the file
		:returns: HTTP Response

		::

				< HTTP/1.1 204 OK
				< Date: Mon, 24 Jan 2022 23:38:41 GMT
				< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
				< X-Powered-By: PHP/8.0.14

		.. note:: Error will send a 400 or more code error and a JSON Object with the error message.


	.. php:method:: v2/files [PUT]

		Put a file in the FTP Server.

		Need to use the PUT HTTP methode.

		This methode is private, you need to pass by the index method ( http://localhost/codeIgniter3/files ).

		:param: 'path' : The path to the directory where you want the file to be in.
		:param: 'file' : The file to be uploaded
		:returns: HTTP Response

		::

				< HTTP/1.1 201 Created
				< Date: Tue, 25 Jan 2022 00:13:13 GMT
				< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
				< X-Powered-By: PHP/8.0.14

		..

  .. php:method:: v2/files/move [POST]

		Move a file from a directory to another.

		Need to use the POST HTTP methode.

		:param: 'pathSrc' : The path to the directory where the file is.
		:param: 'pathDst' : The path to the directory where you want to move the file.
		:param: 'filename' : The name of the file.

		::

			< HTTP/1.1 200 OK
			< Date: Mon, 24 Jan 2022 23:51:47 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 0
			< Content-Type: text/html; charset=UTF-8

		..


Dirs
==================

.. php:class:: v2/dirs

	.. php:method:: v2/dirs

		Accessible with HTTP request method POST, GET or DELETE.

		In function of the request methode, this will call respectively the function mkdir, ls or rmdir.

	.. php:method:: v2/dirs [POST]

		Create a new directory. (equivalent to a mkdir)

		You need to use the index method with POST HTTP method.

		:param: 'path' : The path with the new directory include.
		:returns: HTTP Response

		::

			< HTTP/1.1 201 Created
			< Date: Tue, 25 Jan 2022 00:13:13 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 0
			< Content-Type: text/html; charset=UTF-8

		..


	.. php:method:: v2/dirs [DELETE]

		Remove a directory. (equivalent to a rmdir)

		This will remove all the files and directory inside the directory who is deleted.

		You need to use the index method with DELETE HTTP method.

		:param: 'path' : The path with the directory to remove include.
		:returns: HTTP Response

		::

			< HTTP/1.1 204 OK
			< Date: Tue, 25 Jan 2022 00:12:39 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14

		..

	.. php:method:: v2/dirs [GET]

		List all the directory and the file name. (equivalent to a ls)

		If no path has been precised, this will send the result command with the current directory (.).

		You need to use the index method with GET HTTP method.


		:param: 'path' : The path to list all the file and directory names
		:returns: HTTP Response with JSON Object

		::

			< HTTP/1.1 200 OK
			< Date: Tue, 25 Jan 2022 00:11:32 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 763
			< Content-Type: text/html; charset=UTF-8
			<
			[
				"Directory1",
				"Directory2",
				"File1.txt",
				"File2.txt",
				"File3.txt"
			]

		..

	.. php:method:: v2/dirs/lsl [GET]

		List all the directory and the file with more informations. (equivalent to a ls -l)

		If no path has been precised, this will send the result command with the current directory (.).

		:param: 'path' : The path to list all the file and directory names
		:returns: HTTP Response with JSON Object

		::

			< HTTP/1.1 200 OK
			< Date: Tue, 25 Jan 2022 00:10:30 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 763
			< Content-Type: text/html; charset=UTF-8
			<
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
	.. php:method:: v2/dirs/pwd [GET]

		Return the current path to the current directory

		Need to use the GET HTTP method.

		:returns: HTTP Response with JSON Object

		::

			< HTTP/1.1 200 OK
			< Date: Tue, 25 Jan 2022 00:09:53 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 11
			< Content-Type: text/html; charset=UTF-8
			<
			{
				"pwd":"/"
			}

		..
