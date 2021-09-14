# conversational-recommender-jiis

This repository contains the code and the data used in the experiment of the paper "An Empirical Evaluation of Active Learning Strategies for Profile Elicitation".

# Step 1 - Create the Dialogflow Agent
The Dialogflow agent is in charge of handling the Intent Recognition functions.
To set it up:
1. Create an account on Dialogflow. 
2. Create a new agent, and import the pre-made agent from the MovieRecSysAgent.zip file. To do this, go to Settings -> Export and Import -> Import from zip.
3. Important: In the Agent settings, set the API version to V2.
4. Create a service account, and download the JSON key file, following the tutorial at the following link: https://cloud.google.com/dialogflow/es/docs/quick/setup#sa-create. Important: Do not lose the file that you’ve downloaded.
5. Save the name of the Dialogflow agent (Settings -> General -> Google project -> Project ID).

# Step 2 - Set up the database
The database used by the system is MySQL. We provided a file called database/mrss.sql, that already contains the schema of the database, plus all the entities for the movie domain. So, in order to make it work, you just need to create a new database in MySQL, and transfer the contents of the dump to the newly created database (See the guide at https://www.digitalocean.com/community/tutorials/how-to-import-and-export-databases-in-mysql-or-mariadb , Importing the Database).

# Step 3 - Set up and configure the Service component
The service component of ConveRSE covers the Dialog Manager and Recommendation Services functionalities.
To set it up:
Configure the system, by going into the resources/configuration.json file, where you should set the following parameters:
recSysServiceBasePath: the URL of the machine that will host the service
In the “databaseConf” object, set the URL and name of the database that you’ve created in Step 2, along with the user name and the password needed to access the database.
dialogflowV2AgentName: set the name of the Dialogflow agent obtained in Step 1.
dialogflowV2CredentialsPath: set the path in which you’ve stored the JSON key file obtained in Step 1.
If everything is set correctly, you should be able to interact with the system directly from the console without the need of the Client component, by running the test.TestInterface class from Eclipse. This can be useful to quickly test a feature without re-deploying the entire framework.
To deploy the Service component, export the project as a WAR archive. Then, use the Tomcat App Manager to deploy the WAR file in your system.

# Step 4 - Set up and deploy the Client component
The bot component provides the interface between the system and a messaging platform. 
The PHP code for the client is available at the following repository: https://github.com/aiovine/RecSysBot-apache
This section describes the instructions for setting up a bot on the Telegram platform.
The first step is creating a new bot via the @BotFather channel, which will produce an access token. Before deploying the bot, some configurations are required. In the register.php file the following lines should be edited:

$WEBHOOK_URL = '<URL in which the bot is hosted>/execute.php';
$BOT_TOKEN = '<Bot access token>';

In the recsysbot/config/movierecsysbot-config.php file the following lines should be edited:

'telegram_token' => '<Bot access token>'
'base_uri' => '<Base URL of the Core Service>;
'application_uri' => '<Service name (the name with which the system is deployed on Tomcat)>';

The bot can be then deployed to a PHP server. In order to register the bot, visit the URL <bot path>/register.php with a Web browser. If the output of the page is:

"{"ok":true,"result":true,"description":"Webhook was set"}"

the bot was registered correctly and it will be able to communicate with the user.

Important: In case you need to deploy the client to a local PHP server, you need to supply a SSL certificate. In case you have a self-signed SSL certificate, you will need to use the registerWithCertificate.php file, instead of register.php. In addition to this, in this file you will need to set an additional parameter:
$CERTIFICATE_PATH = <path of the .crt file containing the SSL certificate>;
