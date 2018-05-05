<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentationTitle extends Model
{
    public function subtitle(){
    	return $this->hasMany(DocumentationSubtitle::class, 'title_id');
    }
}
