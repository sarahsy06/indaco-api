<?php
namespace App\Http\Transformer;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use Ordent\RamenRest\Transformer\RestTransformer;
use App\Http\Model\User;
class UsersTransformer extends RestTransformer
{
  protected $availableIncludes = [
    'roles',
  ];

  public function includeRoles(User $e){
    $data = $e->roles;
    return $this->collection($data, new RolesTransformer);
  }
}