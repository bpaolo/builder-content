------------------------------------------------------------------------------------------------------
arquivo:
contentController
linha:
161

cod:
$content = str_replace('../../../../../','C:/xampp/htdocs/gte-builder/public/', $content);

obs:
C:/xampp/htdocs/gte-builder/public/ : endereça físico para ckfider/image armazenar de envio para servidor


------------------------------------------------------------------------------------------------------
arquivo:
templateController

Linha:
50

cod:
if($value->name == 'element6'){
$value->content = str_replace('C:/xampp/htdocs/gte-builder/public/', '../../../../', $value->content);

obs:
 verificar o endereço físico do repositorio no servidor 

----------------------------------------------------------------------
//Gerando Migrações
php artisan make:migration create_users_table --create=users


//Rodar migrates
php artisan migrate

//Criando uma Seeder:

 php artisan make:seeder UsersTableSeeder

 Agora que criou a classe de Seeder para inserir um novo usuário, o próximo passo é registrar essa nova Seeder, para isso abra a classe DatabaseSeeder (database/seeds/DatabaseSeeder.php) e registre a nova classe:


public function run()
{
    $this->call(UsersTableSeeder::class);

}


//rodar seeds
php artisan db:seed

//rodar seeds específica
php artisan db:seed --class=UsersTableSeeder


//caso não ache
composer dump-autoload
