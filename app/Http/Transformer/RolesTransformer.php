<?php
namespace App\Http\Transformer;
 
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use Ordent\RamenRest\Transformer\RestTransformer;
use App\Http\Model\Role;
use App\Http\Model\User;
class RolesTransformer extends RestTransformer
{
  protected $availableIncludes = [
    'users'
  ];
 
  public function includeUsers(Role $e){
    $data = $e->users;
    return $this->collection($data, new UsersTransformer);
  }
}