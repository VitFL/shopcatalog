<h1>Simple Shops Catalog</h1>
<p>Very simple shops catalog project, written on PHP & Yii2 Framework for educational purposes.</p>

<h3>CONFIGURATION</h3>
<h5>Download required modules</h5>
After cloning this repository, go to project root dir, and update dependencies with Composer:
<code>php composer update</code>

<h5>Database</h5>
<p>Create a database and edit the file config/db.php with real data, for example:</p>
<pre>
return [
          'class' => 'yii\db\Connection',
          'dsn' => 'mysql:host=localhost;dbname=shopcatalog',
          'username' => 'shopcatalog',
          'password' => 'catalogpass',
          'charset' => 'utf8',
      ];
</pre>

<h5>Migrations</h5>
<p>Run this migration command, it will create database tables for shopcatalog application:</p>
<code>php yii migrate</code>

<p>Run this migration command, it is needed for User authentication module:</p>
<code>php yii migrate --migrationPath=@vendor/amnah/yii2-user/migrations</code>





<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
   
