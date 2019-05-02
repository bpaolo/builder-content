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