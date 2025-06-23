<?php 
namespace App\Http\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait CanLoadRelations
{
    // /**
    //  * Load the specified relations for the model.
    //  *
    //  * @param array $relations
    //  * @return $this
    //  */
    public function loadRelations( Model|Builder|EloquentBuilder $for, ?array $relations = null ):Model|Builder|EloquentBuilder
    {

        $relations = $relations ?? $this->relations ?? [];

         foreach($relations as $relation){
            $for->when($this->shouldIncludeRelation($relation),fn($q)=> $for instanceof Model ? $for->load($relation) : $q->with($relation));
        }

        return $for;
    }
     protected function shouldIncludeRelation(string $relation)
    {

        $include = request()->query('include'); // Get the 'include' query parameter
        if(!$include){
            return false; // If no relation is specified, do not include it
        }
  
        $relations = array_map('trim',explode(',', $include));
        
        // Split the relations by comma

        return in_array($relation, $relations);
 }
}


?>