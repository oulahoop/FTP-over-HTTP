.. FTPoverHTTP documentation master file, created by
   sphinx-quickstart on Mon Jan 24 12:20:44 2022.
   You can adapt this file completely to your liking, but it should at least
   contain the root `toctree` directive.

Welcome to FTPoverHTTP's documentation!
=======================================

.. toctree::
   :maxdepth: 2
   :caption: Contents:


Files
==================

.. php:class:: 	v2/files

	.. php:method:: v2/files

		Depending on the verb, this will:

			- put a file (PUT).

			- download a file (GET).

			- delete a file (DELETE).


	.. php:method:: v2/files?path= [GET]

		Download a file from the FTP Server.

		:param: 'path' : The path to the file
		:returns: HTTP Response :

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

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

		Delete a file from the FTP Server. Path need to be precised in the body.

		:param: 'path' : The path to the file
		:returns: HTTP Response :

					- 204 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		::

				< HTTP/1.1 204 OK
				< Date: Mon, 24 Jan 2022 23:38:41 GMT
				< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
				< X-Powered-By: PHP/8.0.14

		..

	.. php:method:: v2/files [PUT]

		Upload a file in the FTP Server. Path and file need to be precised in the body.

		:param: 'path' : The path to the directory where you want the file to be in.
		:param: 'file' : The file to be uploaded.
		:returns: HTTP Response :

					- 201 Created.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		::

				< HTTP/1.1 201 Created
				< Date: Tue, 25 Jan 2022 00:13:13 GMT
				< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
				< X-Powered-By: PHP/8.0.14

		..

	.. php:method:: v2/files/move [POST]

		Move a file from a directory to another. The parameters need to be precised in the body.

		:param: 'pathSrc' : The path to the directory where the file is.
		:param: 'pathDst' : The path to the directory where you want to move the file.
		:param: 'filename' : The name of the file.
		:returns: HTTP Response :

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		::

			< HTTP/1.1 200 OK
			< Date: Mon, 24 Jan 2022 23:51:47 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 0
			< Content-Type: text/html; charset=UTF-8

		..

	.. php:method:: v2/files/rename [POST]

		Rename a file. The parameters need to be precised in the body.

		:param: 'path' : The path to the directory of the file.
		:param: 'previousName' : The previous name of the file.
		:param: 'newName' : The new name of the file.
		:returns: HTTP Response :

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		::

			< HTTP/1.1 200 OK
			< Date: Mon, 24 Jan 2022 23:52:17 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 0
			< Content-Type: text/html; charset=UTF-8

		..

Dirs
==================

.. php:class:: v2/dirs

	.. php:method:: v2/dirs

		Depending on the verb, this will:

			- create a new directory (POST)

			- delete a directory and it's content (DELETE)


	.. php:method:: v2/dirs [POST]

		Create a new directory (equivalent to a mkdir). The path need to be precised in the body.

		:param: 'path' : The path with the new directory included.
		:returns: HTTP Response :

					- 201 Created.

					- 400 Bad Request.

					- 406 Not Acceptable

		::

			< HTTP/1.1 201 Created
			< Date: Tue, 25 Jan 2022 00:13:13 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 0
			< Content-Type: text/html; charset=UTF-8

		..


	.. php:method:: v2/dirs [DELETE]

		Remove a directory (equivalent to a rmdir). The path need to be precised in the body.

		This will remove all the files and directory inside the directory that is deleted.

		:param: 'path' : Path of the directory to delete
		:returns: HTTP Response :

					- 204 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		::

			< HTTP/1.1 204 OK
			< Date: Tue, 25 Jan 2022 00:12:39 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14

		..

	.. php:method:: v2/dirs/ls?path= [GET]

        List all elements of the directory with their names.

		:param: 'path' : Path to the directory
		:returns: HTTP Response with JSON Object

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		.. note:: If no path has been specified this will return the list of elements in the root (understand basic) directory

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



	.. php:method:: v2/dirs/lsl?path= [GET]

		List all the directory and the file with more information. (equivalent to a ls -l)

		:param: 'path' : Path to the directory
		:returns: HTTP Response with JSON Object

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		.. note:: If no path has been specified this will return the list of elements in the root (understand basic) directory

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

		Return the current path to the current directory.

		:returns: HTTP Response with JSON Object

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

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

		.. php:method:: v2/files/rename [POST]

		Rename a directory. The parameters need to be precised in the body.

		:param: 'path' : The path to the directory of the directory.
		:param: 'previousName' : The previous name of the directory.
		:param: 'newName' : The new name of the directory.
		:returns: HTTP Response :

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		::

			< HTTP/1.1 200 OK
			< Date: Mon, 24 Jan 2022 23:53:57 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 0
			< Content-Type: text/html; charset=UTF-8

		..

	.. php:method:: v2/dirs/move [POST]

		Move a directory from a directory to another. The parameters need to be precised in the body.

		:param: 'pathSrc' : The path to the directory where the directory is.
		:param: 'pathDst' : The path to the directory where you want to move the directory.
		:param: 'filename' : The name of the directory.
		:returns: HTTP Response :

					- 200 OK.

					- 400 Bad Request.

					- 404 Not Found.

					- 406 Not Acceptable

		::

			< HTTP/1.1 200 OK
			< Date: Mon, 24 Jan 2022 23:51:47 GMT
			< Server: Apache/2.4.52 (Unix) OpenSSL/1.1.1m PHP/8.0.14 mod_perl/2.0.11 Perl/v5.32.1
			< X-Powered-By: PHP/8.0.14
			< Content-Length: 0
			< Content-Type: text/html; charset=UTF-8

		..
